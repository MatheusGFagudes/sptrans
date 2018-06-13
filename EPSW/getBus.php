<?php  
             $cookie_jar = tempnam('/tmp','cookie');

// log in

      $url = 'http://api.olhovivo.sptrans.com.br/v2.1/Login/Autenticar?token=9353032f64292334e163a5d7ab4e069df05670d2e9deae7ac460dcb2b8fdde82';
      $curl = curl_init($url);

      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl, CURLOPT_POST, true);
      curl_setopt($curl, CURLOPT_POSTFIELDS, "");
      curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie_jar);  // aqui grava o cookie que retorna do metodo POST
      $result = curl_exec($curl);

// get Posicao

      $url = 'http://api.olhovivo.sptrans.com.br/v2.1/Posicao';
      curl_setopt($curl, CURLOPT_URL, $url); 
      curl_setopt($curl, CURLOPT_POST, false);
      curl_setopt($curl, CURLOPT_COOKIEFILE, $cookie_jar); // aqui usa o cookie gravado anteriormente no login


      $result = curl_exec($curl);
      $obj = json_decode($result, true);
    
			header('Content-type: application/json');
   echo $result;

      curl_close($curl);


 ?>