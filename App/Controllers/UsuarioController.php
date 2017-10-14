<?php
    namespace App\Controllers;
    
    use App\Models\usuarioDAO;
    use App\Models\Entidades\Usuario;
    use App\Lib\src\facebook;
  

    session_start();

    class UsuarioController extends Controller
    {
        public function index(){
            $this->redirect("usuario/Cadastro");
        }

        public function Cadastro(){
            $this->render("usuario/Cadastro");
        }

        public function Login(){
          
            $url = '';
            

            $face = new Facebook(array(
                'appId' => '131535117502383',
                'secret'=> '274a481b140984793a353262b64d95ef'
            ));

            //pegar o usuario
            $usuarioFace = $face->getUser();

            if($usuarioFace){
                try{
                    //pegando o profile
                    $usuario_profile = $face->api("/me");


                }catch(FacebookApiException $erro){
                    $usuario = null;
                    throw new Exception($erro.getMessage()."Página não encontrada. ",700);
                }

            }else{
                //pegar a url para login
                $url = $face->getLoginUrl(array('scope','email'));

            }
            //teste
            echo "URL :".$url;
            echo "  USUARIO= ".$usuarioFace;
            print_r( $usuario_profile);
            $this->renderLoginFacebook("usuario/Login",$usuarioface,$url)
           // $this->render("usuario/Login");
        }

        public function validaLogin(){
            
            $emailt = $_POST['email_log'];
            $senhat = $_POST['senha_log'];
            //echo $emailt."   ".$senhat;
            
             $usuario= new usuarioDAO();            
             
                if($emailt != NULL && $senhat != NULL){
                    $dadoLogin=$usuario ->validarusuario($emailt, $senhat);
                   // echo $dadoLogin;
                    if($dadoLogin != null){
                        $_SESSION["msg_login"] = "Dados validados";
                        $_SESSION["nome_usuario"]= $dadoLogin->nome_usuario;
                        $_SESSION["email_usuario"]= $dadoLogin->email_usuario;
                        $_SESSION['id_user'] = $dadoLogin->id_usuario;
                        
                        $this->redirect("usuario/login");
                        
                    }else{
                        $_SESSION["msg_erro_login"] = "Usuário não encontrado!!!";
                        $this->redirect("usuario/login");
                    }
            }
           
        }

        public function sucesso(){      
            $this->render("usuario/sucesso");
        }

        public function Salvar(){
            $usuarioD = new usuarioDAO();
            $usuario = new Usuario();

            $usuario->setNome($_POST['nome_usuario']);
            $usuario->setEmail($_POST['email_usuario']);
            $usuario->setSenha($_POST['senha_usuario']);

           //verifica se a funcao verificaEmail() retornou algum email 
            $msg = null;
            if($usuarioD->verificaEmail($usuario->getEmail()) > 0){//retornou email
                $msg = "Email já cadastrado";
                $_SESSION["msg"] = $msg;
                $this->contagemRegressiva();
                $this->redirect("usuario/Cadastro");
            
            }else{//nao retornou nenhum email
                
                $usuarioD->usuarioInserir($usuario);
                $msg = "Usuário cadastrado com sucesso";
                $_SESSION["sucesso"] = $msg;
                $this->redirect("Usuario/cadastro");
            }
          
        }
        
        
        public function cadcom() {
           $nome = $_POST["nome_com"];
           $comentario = $_POST["comentario"];
           
           $usuario = new usuarioDAO();
           
           $cadastra = $usuario->cadastraComentario($nome, $comentario);
           
           if($cadastra > 0){
               echo 'Comentario cadastrado...';
               
           } else {
               
           }
        }
        
        public static function getComentarios() {
            $usuario = new usuarioDAO();
           
           $coment = $usuario->retornaComentarios();
           
           if($coment != null){
               return $coment;
           }
        }
        
        public function logoutFacebook() {
            $face = new Facebook(array(
                'appId' => '131535117502383',
                'secret'=> '274a481b140984793a353262b64d95ef'
            ));
            $face->destroySession();
          
            $this->redirect("vazamento");
            
        }
        public function logout() {
            
            unset($_SESSION["nome_usuario"]);
            unset($_SESSION["id_user"]);
            unset($_SESSION["email_usuario"]);
            
            $this->redirect("vazamento");
            
        }
        
        public static function UrlAtual(){
            $dominio= $_SERVER['HTTP_HOST'];
            $url = "http://" . $dominio. $_SERVER['REQUEST_URI'];
            return $url;
            }
    }
    