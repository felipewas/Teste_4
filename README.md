# prova_bdr
Teste de Conhecimentos – Analista Desenvolvedor 

Istruções para Rodar o Teste 4

1 - Criar a Tabela na base de dados para o aplicativo
Importar o arquivo tabela_tarefas.sql do diretorio raiz

2 - Alterar as configurações da base de dados no arquivo api.php da pasta /services

		const DB_SERVER = "127.0.0.1";
		const DB_USER = "root";
		const DB_PASSWORD = "";
		const DB = "tarefas";

3 - Certificar que o arquivo .htacess da pasta /services está sendo executado apropriadamente 
modulo do apache (rewrite_module) deve estar ativado 

