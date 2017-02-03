<?php
/**
 * UIoT Service Layer
 * @version alpha
 *                          88
 *                          ""              ,d
 *                                          88
 *              88       88 88  ,adPPYba, MM88MMM
 *              88       88 88 a8"     "8a  88
 *              88       88 88 8b       d8  88
 *              "8a,   ,a88 88 "8a,   ,a8"  88,
 *               `"YbbdP'Y8 88  `"YbbdP"'   "Y888
 *
 * @author Universal Internet of Things
 * @license MIT <https://opensource.org/licenses/MIT>
 * @copyright University of Brasília
 */

include_once ("Treaters/MessageOutPut.php");
include_once ('Database/DatabaseParser.php');
use Raise\Treaters\MessageOutPut;

Class QueryGenerator
{
    public function generate($request)
    {

        $parsedPath = $this->parsePath($request);
        if ($parsedPath !== FALSE && $parsedPath->isValid() === TRUE)
        {
            $parser = new DatabaseParser($parsedPath);
            if ($request->getMethod() == "GET")
            {
                $request = $this->buildQuery($request);
                $result = $parser->select($request);
            } elseif ($request->getMethod() == "POST")
            {
                $result = $parser->insert($request);
            }
            return $result;
        }
        elseif($parsedPath->isValid() === FALSE)
        {
          return (new MessageOutPut)->messageHttp($request->getReponseCode());
        }
        else
        {
            return array('code'=>200,'message'=>'Welcome to RAISE!');
        }
    }

    private function generateToken()
    {
       return bin2hex(openssl_random_pseudo_bytes(16));
    }

    private function buildQuery($request)
    {
        if(count($request->getParameters())>0)
        {
          $queryStr = "SELECT * FROM `".$request->bucket."` WHERE";
          foreach ($request->getParameters() as $key => $parameter)
          {
              $queryStr = $queryStr . " " . $key . " LIKE \$$key" . "AND ";
          }
          $request->string = substr($queryStr, 0, -4);
        }
        else
        {
        $request->string = "SELECT * FROM `".$request->bucket."`";
        }

        return $request;
    }

    private function validateToken($result,$request)
    {

      if(isset($result['values'][0]))
      {
        unset($request->string);
        $requestBody = json_decode(json_encode($result['values'][0]),true);
        if($requestBody["time_fim"] > round(microtime(true) *1000))
        {
          unset($requestBody["time_ini"]);
          unset($requestBody["time_fim"]);
          $request->bucket = "client";
          $request->treatedBody = json_encode(array_merge($request->getBody(),$requestBody));
          $request->token = $requestBody['tokenId'];
          unset($requestBody['tokenId']);
        }
        else
        {
          $request->setResponseCode(401);
          $request->setValid(false);
        }
      }
      else
      {
        $request->setResponseCode(401);
        $request->setValid(false);
      }

      return $request;

    }

    private function parsePath($request)
    {
        $path = $request->getPath();
        $method = $path[2];
        if (!empty($method))
        {

          if($request->getPath()[2] === "client" && $request->getPath()[3] == "register")
          {

            $request->bucket = "token";
            $request->token = $this->generateToken();
            $tokenIni = round(microtime(true) *1000);
            $tokenFim = $tokenIni + 7200000;
            $request->treatedBody = json_encode(array_merge($request->getBody(),array('tokenId'=>$request->token,'time_ini'=>$tokenIni,'time_fim'=>$tokenFim)));
            $parser = new DatabaseParser($request);
            $parser->insert($request);
            $request->bucket = "client";
            $request->treatedBody = $request->getBody();

          }
          elseif ($request->getPath()[2] === "service" && $request->getPath()[3] == "register")
          {
            $request->bucket = "token";
            $parser = new DatabaseParser($request);

            //Select Client on Token bucket
            $token = $request->getBody()['tokenId'];
            $request->string = 'SELECT * FROM `token` WHERE tokenId = $token';
            $request->setParameters(array('token'=>$token));
            $result = $parser->select($request);
            $request = $this->validateToken($result,$request);
            //End select

            //create Client

            //end create
          }
          else
          {
            $request->token = $this->generateToken();
            $request->treatedBody = $request->getBody();
          }

            return $request;
        }
        else
        {
            return FALSE;
        }
    }
}
