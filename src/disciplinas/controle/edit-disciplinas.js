function btnClose() {
    // Monitorar o clique em cima da classe btn-close
    $('.btn-close').click(function(e) {
        e.preventDefault()
        $('#form').empty()
        $('#form').hide(2000)
        $('.row').show(2000)
    })
}
$(document).ready(function() {
    // Monitorar os clicks nos botões com as classes btn-view
    $('.btn-edit').click(function(e) {
        e.preventDefault()
            // Iremos capturar o id do botão clicado, para enviar ao nosso serviço PHP
        var dados = `id= ${$(this).attr('id')}`
            // Requisição assincrona para realização da consulta em BD
        $.ajax({
            type: 'POST',
            dataType: 'JSON',
            assync: true,
            data: dados,
            url: 'src/disciplinas/modelo/view-disciplinas.php',
            success: function(dados) {
                $('#form').show(3000)
                $('.row').hide(3000)

                $('#form').load('src/disciplinas/visao/adiciona-disciplinas.html', function() {
                    $('h4').empty()
                    $('h4').append('Editar Registro')

                    $('.btn-save').addClass('btn-update').removeClass('btn-save')
                    $('#nome').attr('disabled', false)
                    $('#nome').val(dados[0].nome)
                    $('#professor').attr('disabled', false)
                    $('#professor').val(dados[0].professor)
                    $('#nota').attr('disabled', false)
                    switch (dados[0].nota) {
                        case 'MB':
                            var mencao = "Muito Bom"
                            break
                        case 'B':
                            var mencao = "Bom"
                            break
                        case 'R':
                            var mencao = "Regular"
                            break
                        case 'I':
                            var mencao = "Insatisfatório"
                            break
                    }
                    $('#nota').append(`<option value="${dados[0].nota}" selected>${mencao}</option>`)
                    $('#nota').after(`<input type="hidden" name="id" id="id" value="${dados[0].id}">`)

                    btnClose()
                })
                $('body').append(`<script src="src/disciplinas/controle/update-disciplinas.js"></script>`);
            }
        })

    })
})