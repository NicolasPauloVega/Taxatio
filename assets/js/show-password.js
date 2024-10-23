document.addEventListener('DOMContentLoaded', function() {
    const password = document.getElementById('pass1')
    const passwordConfirm = document.getElementById('pass2')

    const showPassword = document.getElementById('show-password')

    showPassword.addEventListener('change', function() {
        if(this.checked) {
            password.type = 'text'
            passwordConfirm.type = 'text'
        } else {
            password.type = 'password'
            passwordConfirm.type = 'password'
        }
    })
})