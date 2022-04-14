require('./bootstrap');

const submitBtn = document.querySelector('.submit');
submitBtn.onclick = (e) => {
    e.preventDefault();

    axios.post('/api/i', {}).then(response => {
        console.log(response);
    });
}
