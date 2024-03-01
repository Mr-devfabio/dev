function concluir() {
    const formData = new FormData(document.getElementById('questionForm'));

    fetch('salvar.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Sucesso!',
                text: data.success,
                showConfirmButton: true, // Alterado para true para permitir interação do usuário
                confirmButtonText: 'OK'
            });
        } else if (data.error) {
            Swal.fire({
                icon: 'error',
                title: 'Erro!',
                text: data.error,
                showConfirmButton: false,
                timer: 3000
            });
        }
    })
    .catch(error => {
        console.error('Erro ao salvar os dados:', error);
        console.error('Detalhes do erro:', error.message);
    });
}
