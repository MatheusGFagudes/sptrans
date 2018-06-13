<?php  
        

// log in

      $url = 'http://api.olhovivo.sptrans.com.br/v2.1/Login/Autenticar?token=3ef29018e59574e12342f765509843af42bfd627f0ae5aa9021e566b8fd0486a';
      $curl = curl_init($url);

      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl, CURLOPT_POST, true);
      curl_setopt($curl, CURLOPT_POSTFIELDS, "");
      curl_setopt($curl, CURLOPT_COOKIEJAR, $curl);  // aqui grava o cookie que retorna do metodo POST
      $result = curl_exec($curl);

// get Posicao

      $url = 'http://api.olhovivo.sptrans.com.br/v2.1/Posicao';
      curl_setopt($curl, CURLOPT_URL, $url); 
      curl_setopt($curl, CURLOPT_POST, false);
      curl_setopt($curl, CURLOPT_COOKIEFILE, $curl); // aqui usa o cookie gravado anteriormente no login


      $result = curl_exec($curl);
      $obj = json_decode($result, true);
   
   echo $result;

      curl_close($curl);


 ?>