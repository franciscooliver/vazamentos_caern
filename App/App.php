<?php

    namespace App;

    use App\Controllers\HomeController;
    use Exception;

     Class app{
        private $controller;
        private $controllerFile;
        private $action;
        private $params;
        private $controllerName;

        public function __construct(){
            //constantes do sistema
            define('APP_HOST',$_SERVER['HTTP_HOST']."/"."vazamentos_caern"."/");
            define('PATH',realpath('./'));
            define('TITLE',"V_CAERN");
            define('DB_HOST',"127.0.0.1");
            define('DB_USER',"root");
            define('DB_NAME',"bd_caern");
            define('DB_PASSWORD',"12312");
            define('DB_DRIVER',"mysql");
            define('IMG_LOGO',"_fontes/imgs/logo_vaz_caern.png");
            
            $this->url();
        }
        

        public function run(){
            //$this->url();
            if($this->controller){
               
                $this->controllerName =  ucwords($this->controller).'Controller';// função ucwords, convertendo para maiúsculas o primeiro caractere, concatenado com palavra Controller.
                $this->controllerName = preg_replace('/[^a-zA-Z]/i','',$this->controllerName); //Utiliza a expressão regular para remover qualquer caractere diferente de (A até Z e a até z).
                

                /*codigo teste url amigavel
                $dados =  $this->controllerName; 
                $act = $this->action;
                $para=$this->params[0];
                require("teste.php");
                */
                
            }else{
                $this->controllerName = "HomeController";

            }

            //default 
            if(!$this->controller){
                $this->controller = new HomeController($this);
                $this->controller->index();
                return;
            }

            //setar o controller file
            $this->controllerFile =  $this->controllerName.'.php';
            $this->action         =  preg_replace('/[^a-zA-Z]/i','',$this->action);

            //verificar se o controller existi
            if(!file_exists(PATH.'/App/Controllers/'.$this->controllerFile)){
                //$dados = PATH.'/App/Controllers/'.$this->controllerFile;
                //require('teste.php');
                throw new Exception("Página não encontrada. ",404);
            }

            //setando o nome da class
            $nomeClasse = "\\App\\Controllers\\". $this->controllerName;
            $objetoController = new $nomeClasse($this);

            //verficar se a class existi
            if(!class_exists($nomeClasse)){
                throw new Exception("Erro na aplicação",500);
            }

            //verificando method nos controllers
            if(method_exists($objetoController,$this->action)){
                $objetoController->{$this->action}($this->params);//passa o parametro para o controller
                return;
            }else if(!$this->action && method_exists($objetoController,'index')){
                $objetoController->index($this->params);
                return;

            }else{
                throw new Exception("Nosso suporte ja esta verificando desculpe!",500);

            }
            throw new Exception("Página não encontrada",404);
            

           
        }

        //url amigavel
        public function url(){
            if(isset($_GET['url'])){
               
                $path = $_GET['url'];
                $path = rtrim($path,'/');//separando por barras
                $path = filter_var($path, FILTER_SANITIZE_URL);

                $path = explode('/',$path);

                $this->controller = $this->verificarArray($path,0);
                $this->action = $this->verificarArray($path,1);

                if($this->verificarArray($path,2)){
                    unset($path[0]);
                    unset($path[1]);
                    $this->params = array_values($path);

                }
            }            
           
        }
        public function getControllerName(){
            return $this->controllerFile;
        }

        private function verificarArray( $array, $key ) {
             if ( isset( $array[ $key ] ) && !empty( $array[ $key ] ) ) {
                return $array[ $key ];
                
             }
            return null;
        }

    }

?>

