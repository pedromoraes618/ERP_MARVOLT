

$(document).ready(function(){
   
    var usuario = document.getElementById("usuario").value;
    var senha = document.getElementById("senha").value;
    var xhr = new XMLHttpRequest();

    // Configura a requisição
    xhr.open("POST", "login/login_lembra.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    // Envia a requisição
    xhr.send("usuario=" + usuario + "&senha=" + senha);

    // Verifica o status da requisição
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Recupera a resposta do servidor
            var resposta = xhr.responseText;

            // Verifica se a resposta é "ok"
            if (resposta === "ok") {
                // Redireciona para a página inicial
                window.location.href = "index.php";
            }
        }
    }
})



$("#btn_login").click(function() {

    var usuario = document.getElementById("usuario").value;
    var senha = document.getElementById("senha").value;
    var lembrar_senha = document.getElementById("lembrar_senha")

    if(lembrar_senha.checked) {//verificar se o usuario quer pra lembrar a senha
     var data_de_expiracao = new Date();
     data_de_expiracao.setTime(data_de_expiracao.getTime() + (106400 * 10000)); // expira em um dia
     var tempo_de_vida_do_cookie = "expires=" + data_de_expiracao.toUTCString();
     const generateUniqueId = () => { //função para gerar um id aleatorio 
         return Math.floor(Math.random() * 1000000) + Date.now();
     };
     var chave_aleatoria = generateUniqueId();
     
     document.cookie = "algnmarvolt=" + chave_aleatoria + "; "+tempo_de_vida_do_cookie+" ; path=/"

    } else {
     var chave_aleatoria = "";
    }
  
    // Cria um objeto XMLHttpRequest
    var xhr = new XMLHttpRequest();

    // Configura a requisição
    xhr.open("POST", "login/login_crud.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    // Envia a requisição
    xhr.send("usuario=" + usuario + "&senha=" + senha +"&chave_aleatorio="+ chave_aleatoria);

    // Verifica o status da requisição
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Recupera a resposta do servidor
            var resposta = xhr.responseText;

            // Verifica se a resposta é "ok"
            if (resposta === "ok") {
                // Redireciona para a página inicial
                window.location.href = "index.php";
            } else {
                // Exibe uma mensagem de erro
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: resposta,
                    footer: ''
                })
            }
        }
    }
})