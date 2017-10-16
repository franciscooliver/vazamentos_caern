<?php

    namespace App\Models;
    use App\Models\BaseDAO;
    use App\Models\Entidades\Usuario;
    use Exception;

    class usuarioDAO {
        private $conPdo;

        public function __construct(){
            $this->conPdo = BaseDAO::getConnection();
        }

        public function usuarioInserir(Usuario $usuario){      
        try{
           
            
           //recupera dados do usuario
            $nome = $usuario->getName();
            $email =$usuario->getEmail();
            $senha=$usuario->getSenha();
           
            
            //prepara query de insercao
            $insere = $this->conPdo->prepare("INSERT INTO caern_usuario(nome_usuario,email_usuario,senha_usuario) VALUES(:nome,:email,:senha)");
            $insere->bindParam(':nome',$nome);
            $insere->bindParam(':email',$email);
            $insere->bindParam(':senha',$senha);
          
            //verifica se operacao foi bem sucedida
            if($insere->execute()){
               if($insere->rowCount() > 0){
                   return $insere->rowCount();
               }
                
            }
             
        }catch(PDOException $e){
            echo $e->getMessage();
        }
        }

       public function verificaEmail($email) {
            try {
                
                //selecionando email cadastrado no banco com PDO
                $email = "'".$email."'";
                $query = $this->conPdo->prepare("SELECT * FROM caern_usuario WHERE email_usuario = $email");
                
                //verifica se a operacao foi bem sucedida
                if($query->execute()){
                    //verifica se encontrou algum resultado e retorna o numero de colunas 
                    if($query->rowCount() > 0){
                        return $query->rowCount();
                    }
                    
                }
                $query = null;
                
                
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
                }
                
              /*  public function retornaLogin($email, $senha) {
                   try{ 
                    $sql = "SELECT id_usuario,email_usuario, senha_usuario FROM caern_usuario WHERE email_usuario = '$email' "
                            . "AND senha_usuario = '$senha'";
                    
                    $query = $this->conPdo->prepare($sql);
                    
                    
                    if($query->execute()){
                        if($query->rowCount() > 0){
                            while ($row = $query->fetch(\PDO::FETCH_OBJ)) {
                                
                            }
                            foreach ($query as $dados){
                                return $dados->email_usuario;
                            }
                        }
                    }
                    $query = null;
                    
                } catch (PDOException $e){
                    echo $e->getMessage();
                }                
                */
                public function validarusuario($emailt, $senhat){
                    try {
                        $sql = "SELECT id_usuario,nome_usuario,email_usuario FROM caern_usuario WHERE email_usuario = '$emailt' "
                                . "AND senha_usuario = '$senhat'";
                        
                        $query = $this->conPdo->prepare($sql);
                       // print_r($query);
                        
                    if($query->execute()){
                        if($query->rowCount()>0){
                          while($row=$query->fetch(\PDO::FETCH_OBJ)){
                              return $row;
                          }
                           
                        }
                    }
                        
                        
                    } catch (\PDOException $ex) {
                        throw new Exception($ex, 500);
                    }
           }
           
           public function cadastraComentario($nome,$comentario) {
               
               try {
                   $sql = "INSERT INTO comentarios_vaz(nome,comentario) VALUES(:nome,:comentario)";
                   $insere = $this->conPdo->prepare($sql);
                   $insere->bindParam(":nome", $nome);
                   $insere->bindParam(":comentario", $comentario);
                   
                   
                   if($insere->execute()){
                       if($insere->rowCount() > 0){
                           return $insere->rowCount();
                       }
                   }
                   $insere = null;
                   
                   
               } catch (Exception $exc) {
                   throw new Exception("Erro ao na operação de cadastro".$exc.getMessage(),500);
               }
                          
           }
           
           public function retornaComentarios() {
               try {
                   $sql = "SELECT nome, comentario FROM comentarios_vaz ";
                   $query = $this->conPdo->prepare($sql);
                   
                   if($query->execute()){
                       while ($row = $query->fetch(\PDO::FETCH_OBJ)){
                           $comentarios[] = $row;
                       }
                       return $comentarios;
                   }
                   $query = null;
                   
                   
               } catch (Exception $exc) {
                   throw new Exception("Erro ao na operação de cadastro",500);
               }
           }

      
    }