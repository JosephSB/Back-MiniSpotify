# BACKEND: API MINI SPOTIFY

## CONSULTAS
Puedes poner tus propias configuraciones en el archivo _Config/config.php_
[ HOST ]: http://localhost/Spotify

### 1. USUARIOS

#### POST:
    ```
        ADD-USUARIO:[ HOST ]/API/usuarios/adduser
        ENVIAR UN POST CON ESTE JSON
        {
            "Username": [ STRING ],
            "Password": [ STRING ],
            "Email": [ STRING ],
            "Name": [ STRING ],
            "LastName": [ STRING ]
        }
    ```
    VALIDAR-USUARIO:[ HOST ]/API/usuarios/ValidateUser
    
    ENVIAR UN POST CON ESTE JSON
    {
        "Username": [ STRING ],
        "Password": [ STRING ]
    }
    ```

### 2.  SONGS
```
    POST:
        UPLOAD-SOUND: [ HOST ]/API/music/Upload

    GET:
        GET-SONGS: [ HOST ]/API/music/getSongs/page=[ pagina ]

```

