document.addEventListener('DOMContentLoaded', async () => {
    try {
        const authSession = `${sessionStorage.getItem('session')}`;
        
        const { data } = await axios.get('../connect/auth.php', {
            headers: {
                "Authorization": authSession
            }
        });

        if (!data) {
            window.location.href = '/projects/Teste-projeto/index.php';
        }

        sessionStorage.setItem('auth', JSON.stringify(data)); 
    } catch (error) {
        sessionStorage.removeItem('auth'); 
        console.log(error);
        if (error.response.data == 'EXPIRED') {
            window.location.href = '/projects/Teste-projeto/index.php';
        }
    }
});


