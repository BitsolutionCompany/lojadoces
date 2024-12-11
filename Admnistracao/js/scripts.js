$(document).ready(function() {
    $('#cpf').on('input', function() {
        let valor = $(this).val().replace(/\D/g, '');
        valor = valor.replace(/(\d{3})(\d)/, '$1.$2');
        valor = valor.replace(/(\d{3})(\d)/, '$1.$2');
        valor = valor.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
        $(this).val(valor);
    });
    $('#cep').on('input', function() {
        let valor = $(this).val().replace(/\D/g, '');
        if (valor.length > 5) {
            valor = valor.replace(/(\d{5})(\d)/, '$1-$2');
        }
        $(this).val(valor);
    });
    $('#cep').on('input', function() {
        let cep = $(this).val().replace(/\D/g, '');

        if (cep.length === 8){
            $.ajax({
                type: 'GET',
                url: `https://viacep.com.br/ws/${cep}/json/`,
                dataType: 'json',
                success: function(data) {
                    if (data.erro) {
                        $('#message').html('CEP não encontrado');
                        $('#cidade').val('');
                        $('#estado').val('');
                    } else {
                        $('#message').html('');
                        $('#cidade').val(data.localidade);
                        $('#estado').val(data.uf);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Erro ao preencher cidade e estado:', error);
                }
            });
        }else{
            $('#message').html('');
            $('#cidade').val('');
            $('#estado').val('');
        }
    });
    $('#birthdate').on('input', function() {
        let valor = $(this).val().replace(/\D/g, ''); // Remove caracteres não numéricos
    
        if (valor.length > 2 && valor.length <= 4) {
            valor = valor.replace(/(\d{2})(\d{2})/, '$1/$2'); // Adiciona a primeira barra após os dois primeiros dígitos
        } else if (valor.length > 4) {
            valor = valor.replace(/(\d{2})(\d{2})(\d{4})/, '$1/$2/$3'); // Adiciona a segunda barra após os próximos dois dígitos
        }
    
        // Limita a entrada a 10 caracteres
        if (valor.length > 10) {
            valor = valor.substring(0, 10);
        }
    
        $(this).val(valor); // Atualiza o valor do campo de entrada
    });
    $('#registerForm').on('submit', function(event) {
        event.preventDefault(); // Impede o envio padrão do formulário

        $.ajax({
            type: 'POST',
            url: 'functions/cadAdm.php', // URL do seu script PHP
            data: $(this).serialize(), // Serializa os dados do formulário
            success: function(response) {
                const res = JSON.parse(response); // Analisa a resposta JSON
                $('#message1').html(res.message); // Exibe a mensagem apropriada

                if (res.status === 'success') {
                    // Redireciona para a página de login
                    window.location.href = res.redirect;
                }
            },
            error: function(xhr, status, error) {
                alert(error)
                $('#message1').html('Erro ao cadastrar administrador.');
            }
        });
    });
});