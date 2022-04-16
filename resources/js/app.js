require('./bootstrap');

const linksForm = () => {

    const submitBtn = document.querySelector('.submit');
    const urlField = document.querySelector('#url');
    const textLink = document.querySelector('.link-text');
    const copyLink = document.querySelector('.copy-link');
    const errorText = document.querySelector('.error-text');
    const errorDescription = document.querySelector('.error-description');

    const clearElements = () => {
        textLink.innerText = '';
        textLink.href = '';
        errorText.innerText = '';

        while (errorDescription.firstChild) {
            errorDescription.removeChild(errorDescription.firstChild);
        }
    }

    const showText = (element, result) => {
        element.innerText = result.message;
        console.log(result.data);
    }

    const handleError = response => {
        if (response.status === 406 || response.data.message === 'Validation error') {
            const ul = document.createElement('ul');
            response.data.data.url.forEach(item => {
                const li = document.createElement('li');
                li.innerText = item;
                ul.append(li);
            });

            errorDescription.append(ul);
        }
    }

    submitBtn.onclick = e => {
        e.preventDefault();

        axios.post('/api/i', { url: urlField.value }).then(response => {
            clearElements();

            if (response.data.status === 'error') {
                showText(errorText, response.data);
                handleError(response);
            } else {
                showText(textLink, response.data);
                textLink.href = response.data.message;
            }
        }).catch(error => {
            clearElements();

            if (error.response) {
                showText(errorText, error.response.data);
                handleError(error.response);
                console.log('Error code: ' + error.response.status);
                console.log(error.response.headers);
            } else if (error.request) {
                console.log(error.request);
            } else {
                console.log('Error', error.message);
            }
            console.log(error.config);
        });
    }

    if (location.protocol === 'https:') {
        copyLink.onclick = e => {
            navigator.clipboard.writeText(textLink.innerText);
        }
    }

}

linksForm();
