if(window.location.pathname != '/') {

    $(function () {

        let modal = new bootstrap.Modal(document.getElementById('form_modal'), {backdrop: 'static'})
        let modal_body = $('.modal-body')

        $(document).on('click', '.show_form_modal', function (e) {
            e.preventDefault()
            $('.modal-title').html($(this).data('modal_title'))
            let method = 'get'
            let url = $(this).data('route')
            let data
            let dataType = 'html'
            call_ajax(method, url, data, dataType)
        })

        $(document).on('submit', '#record_form', function (e) {
            e.preventDefault()
            let method = 'post'
            let url = $(this).attr('action')
            let data = $(this).serialize()
            let dataType = 'json'
            call_ajax(method, url, data, dataType)
        })

        let call_ajax = function (method, url, data, dataType) {
            disable_form_ui(method)
            $.ajax({
                method: method,
                url: url,
                data: data,
                dataType: dataType
            }).done(function (response, textStatus, xhr) {
                if (xhr.status === 200) {
                    if (method === 'post') {
                        if (response.result) {
                            $('#table_ui').load(window.location.pathname + ' #table_ui > *', function () {
                                pause_ui().then(() => modal.hide())
                            })
                        } else {
                            enable_form_ui(response)
                        }
                    } else {
                        $('.modal-body').html(response)
                        modal.show()
                    }
                }
            }).fail(function (error) {
                console.log(error)
            })
        }

        const disable_form_ui = function (method) {
            if (method === 'post') {
                $('#form_button').prepend('<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"/>')
                $('fieldset').attr('disabled', '')
            }
        }

        const enable_form_ui = function (response) {
            $('#input_failure').html(response.message).removeClass('d-none')
            $('#form_button').html('SAVE')
            $('fieldset').removeAttr('disabled')
        }

        const pause = function (ms) {
            return new Promise(
                resolve => setTimeout(resolve, ms)
            );
        }

        async function pause_ui() {
            await pause(750);
        }

    })

}