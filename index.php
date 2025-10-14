<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SICLOFI Operacional - Sistema de controle logístico de fórmula infantil</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    
    <div class="container">
        <div class="form-box active" id="login-form">

            <form action="inicial.php" method="post">

                <img src="images/siclofi.png">

                <select class="form-control" name="uf" id="uf" required>
                    <option value="">UF</option>
                    <option value="AC">AC</option> <!-- TO DO: ADD OUTRAS UF -->
                </select><br>

                <select class="form-control" name="udm" id="udm" required>
                    <option value="">Unidade</option>
                    <option value="178">ANGRA DOS REIS - CENTRO DE ESPECILIDADES MÉDICAS - ANGRA DOS</option> <!-- TO DO: ADD OUTRAS UDM -->
                </select><br>
                
                <input type="text" name="cpf" autocomplete="off" minlength="14" maxlength="14" id="cpf" class="form-control" placeholder="CPF" required><br> 
                <script src="script/cpf.js"></script>
                
                <input type="password" name="senha" autocomplete="off" minlength="6" id="senha" class="form-control" placeholder="Senha" required> <br>

                <button type="submit" name="login">Entrar</button>

                <a href="#" class="link" onclick="showForm('forgotPassw-form')">Redefinir senha</a>

            </form>
            
        </div>
        
        <div class="form-box" id="forgotPassw-form">

            <form action="inicial.php" method="post">  

                <img src="images/siclofi.png">

                
                <input type="text" name="cpf" autocomplete="off" maxlength="14" id="cpf" class="form-control" placeholder="CPF" required><br>
                <script src="script/cpf.js"></script> 

                <input type="password" name="senha" autocomplete="off" id="senha" class="form-control" placeholder="Nova Senha" required> <br>
                <input type="password" name="senha" autocomplete="off" id="senha" class="form-control" placeholder="Confirmar Nova Senha" required> 

                <div class="btn-container">
                    <button type="submit" name="redefinir" class="btnforgotPassw-form">Redefinir</button>

                    <button name="voltar" onclick="showForm('login-form')" class="btnforgotPassw-form">Voltar</button>
                </div>

                <p>A solicitação de redefinição de senha pode demorar até 20 dias úteis para ser aceita.</p> <br>

            </form>
            
        </div>
    </div>

    <script src="script/forms.js"></script>

</body>
</html>
