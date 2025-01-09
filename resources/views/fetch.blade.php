<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="url-base" content="{{ url('') }}">
        <title>Document</title>
    </head>
    <body>
        <button id="fetchBt">fetch store</button>
        <button id="fetchUpdateBt">fetch update</button>
        <button id="fetchDestroyBt">fetch destroy</button>
    </body>
    <script>
        let csrf_token = document.querySelector('meta[name="csrf-token"]').content
        let url_base = document.querySelector('meta[name="url-base"]').content
        let fetchBt = document.getElementById('fetchBt')
        fetchBt.addEventListener('click', (event) => {
            fetch(url_base + '/product', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-Token': csrf_token
                },
                body: JSON.stringify({
                        'name': 'pepino',
                        'price': 0.35
                    })
                }).
            then(response => response.json()).
            then(data => {
                console.log(data)
            });
        });
        let fetchUpdateBt = document.getElementById('fetchUpdateBt')
        fetchUpdateBt.addEventListener('click', (event) => {
            fetch(url_base + '/product/173', {
                method: 'PUT',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-Token': csrf_token
                },
                body: JSON.stringify({
                        'name': 'cebolla',
                        'price': 1.78
                    })
                }).
            then(response => response.json()).
            then(data => {
                console.log(data)
            });
        });
        let fetchDestroyBt = document.getElementById('fetchDestroyBt')
        fetchDestroyBt.addEventListener('click', (event) => {
            fetch(url_base + '/product/173', {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-Token': csrf_token
                }
                }).
            then(response => response.json()).
            then(data => {
                console.log(data)
            });
        });
    </script>
</html>