<?php

class Request
{
	protected $url;
	protected $token;

	public function __construct($urlBase = '', $token = '')
	{
		/* Utilizo um ternário para identificar se o último caractere da string é uma barra.
		* Se não for, eu adiciono uma.
		*/
		$this->url   = (substr($urlBase, -1) === '/') 
						? $urlBase 
						: $urlBase.'/';
		$this->token = $token; 
	}

	public function getUrl($extraPath = '')
	{
		if(!empty($extraPath))
		{
			/* Aqui, é verificado se o caminho extra de URL possui uma barra como primeiro caractere.
			* Se tiver, é removido, pois a URL base já termina com barra.
			*/
			$extraPath = (substr($extraPath, 0) === '/')
							? substr($extraPath, 1, strlen($extraPath) - 1)
							: $extraPath;
			/*
			* Nesse trecho, é verificado se o último caractere da string é uma barra.
			* Se não for, eu adiciono uma.
			*/
			$extraPath = (substr($extraPath, -1) === '/') 
							? $extraPath 
							: $extraPath.'/';
		}

		return $this->url.$extraPath; # Retorno da URL
	}

	public function setUrl($urlBase = '')
	{
		$this->url = $urlBase;
	}

	public function doPost($data = [], $header = [])
	{
		$fields = http_build_query($data);

		/* Se o token estiver configurado no objeto de requisição, adicione-o ao HEADER */
		if(!empty($this->token)){ array_push($header, 'token:'.$this->token); }

		//Abre a conexão
		$ch = curl_init();

		//Configura o cabeçalho da requisição
		if(!empty($header)){ curl_setopt($ch, CURLOPT_HTTPHEADER,$header); } # Configuro opções no HEADER apenas se for necessário
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch,CURLOPT_URL,$this->url);
		curl_setopt($ch,CURLOPT_POST,count($data));
		curl_setopt($ch,CURLOPT_POSTFIELDS,$fields);
		
		$result['result'] 	= json_decode(utf8_encode(trim(curl_exec($ch))), false); //Executa a requisição e decodifica o JSON para o formato UTF-8
		$result['code']		= curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch); //Fecha a conexão

		return $result;
	}

	public function doGet($data = [], $header = [])
	{
		$fields = http_build_query($data);

		/* Se o token estiver configurado no objeto de requisição, adicione-o ao HEADER */
		if(!empty($this->token)){ array_push($header, 'token:'.$this->token); }
		
		
		//Abre a conexão
		$ch = curl_init();

		//Configura o cabeçalho da requisição
		if(!empty($header)){ curl_setopt($ch, CURLOPT_HTTPHEADER,$header); } # Configuro opções no HEADER apenas se for necessário 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch,CURLOPT_URL,$this->url.'?'.$fields);
		
		$result['result'] 	= json_decode(utf8_encode(trim(curl_exec($ch))), false); //Executa a requisição e decodifica o JSON para o formato UTF-8
		$result['code']		= curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch); //Fecha a conexão

		return $result;
	}

	public function doDelete($data = [], $header = [])
	{
		$fields = http_build_query($data);

		/* Se o token estiver configurado no objeto de requisição, adicione-o ao HEADER */
		if(!empty($this->token)){ array_push($header, 'token:'.$this->token); }

		//Abre a conexão
		$ch = curl_init();

		//Configura o cabeçalho da requisição
		if(!empty($header)){ curl_setopt($ch, CURLOPT_HTTPHEADER,$header); } # Configuro opções no HEADER apenas se for necessário
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch,CURLOPT_URL,$this->url.'?'.$fields);
		
		$result['result'] 	= json_decode(utf8_encode(trim(curl_exec($ch))), false); //Executa a requisição e decodifica o JSON para o formato UTF-8
		$result['code']		= curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch); //Fecha a conexão

		return $result;
	}
}