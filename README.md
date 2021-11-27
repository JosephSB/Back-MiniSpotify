# BACKEND: API MINI SPOTIFY

## CONSULTAS
Puedes poner tus propias configuraciones en el archivo _Config/config.php_
_[ HOST ]: http://localhost/Spotify_

### 1. USUARIOS

#### POST:
```
    ADD-USUARIO:[ HOST ]/API/usuarios/adduser
    
    ENTRADA:
        {
            "Username": [ STRING ],
            "Password": [ STRING ],
            "Email": [ STRING ],
            "Name": [ STRING ],
            "LastName": [ STRING ]
        }


```
```
    VALIDAR-USUARIO:[ HOST ]/API/usuarios/ValidateUser
    
    ENTRADA:
        {
            "Username": [ STRING ],
            "Password": [ STRING ]
        }
```

### 2.  SONGS
####    POST:
```
        UPLOAD-SOUND: [ HOST ]/API/music/Upload
        
        ENTRADA:
        FORMDATA, GUIARSE DEL FORM.HTML
```
####    GET:
```
        GET-SONGS: [ HOST ]/API/music/getSongs/page=[ pagina ]
```


