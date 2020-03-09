<?php
class Library
{
    public function curl($ENDPOINT, $nvp)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $ENDPOINT);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($nvp));
        curl_setopt($curl, CURLOPT_VERBOSE, true);
        $curlExec = curl_exec($curl);//Armazena o retorno do servidor (NVP) PayPal
        curl_close($curl);//Fecha a comunicação dos servidores
        $response = urldecode($curlExec);//Decoda o formato (NVP) para o PHP
        return  $response;
    }
     
    public function regex($response)
    {
        if ( preg_match_all( '/(?<name>[^\=]+)\=(?<value>[^&]+)&?/' , $response , $matches ) ) {
            foreach ( $matches[ 'name' ] as $offset => $name ) {
                $responseNvp[ $name ] = $matches[ 'value' ][ $offset ];
            }
        }
        return $responseNvp;
    }

//criar outro metodo de credencial para cliente e secret id em rest

    public function getCredential($type)
    {            
        $cred = new stdClass();           
        if($type=="sandbox")
        {
            $cred->user = "sb-e2yfi408566_api1.business.example.com";
            $cred->pwd = "22VPV8KETHF3SC5P";
            $cred->signature = "A574AnRYwVI-eLtXUSUL15KwD9j5A3cDvLroT-8u-KOAFmWP2S0fdkVC";
        }
        else
        {
            if($type=="sandbox1")
            {
            $cred->user = "sb-c33bx368766_api1.business.example.com";
            $cred->pwd = "P8YAEB7PVT9ML7XQ";
            $cred->signature = "A-9Hyj5.n664jOr3Cfh7xTTqeqE-ABhOPkWjtLM0z2.xYHdIS.RFMMiK";
            }
        } 

        return $cred;
    }
    
    public function curlRest($endpoint, $postfields, $header){
        $curl = curl_init();

        $curl_log = fopen('requestCurl.txt','w');
        fwrite($curl_log, pack("CCC",0xef,0xbb,0xbf));

        curl_setopt_array($curl, array(
        CURLOPT_URL => $endpoint,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_VERBOSE => true,
        CURLOPT_STDERR => $curl_log,
        CURLOPT_POSTFIELDS => $postfields,
        CURLOPT_HTTPHEADER => $header
        ));
        $response1 = curl_exec($curl);
        rewind($curl_log);
        fclose($curl_log);
        curl_close($curl);
        $responseArray = json_decode($response1, true);
        
        return $responseArray;
    }

    public function curlRestPatch($endpoint, $postfields, $header){
        $curl = curl_init();

        $curl_log = fopen('requestCurl.txt','w');
        fwrite($curl_log, pack("CCC",0xef,0xbb,0xbf));
        curl_setopt_array($curl, array(
        CURLOPT_URL => $endpoint,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "PATCH",
        CURLOPT_VERBOSE => true,
        CURLOPT_STDERR => $curl_log,
        CURLOPT_POSTFIELDS => $postfields,
        CURLOPT_HTTPHEADER => $header
        ));
        $response1 = curl_exec($curl);
        rewind($curl_log);
        fclose($curl_log);
        curl_close($curl);
        $responseArray = json_decode($response1, true);
        
        return $responseArray;
    }

    public function curlRestGet($endpoint, $header){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => $endpoint,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => $header
        ));
        $response1 = curl_exec($curl);
        $responseArray = json_decode($response1, true);
        
        return $responseArray;
    }
}
?>