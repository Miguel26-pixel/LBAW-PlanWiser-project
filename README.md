# LBAW2181

### 1. Installation

Source code can be found [here](https://git.fe.up.pt/lbaw/lbaw2122/lbaw2181/-/tree/main)
To run the Docker Container:

```docker
composer install
docker run -it -p 8000:80 --name=lbaw2181 -e DB_DATABASE="lbaw2181" -e DB_SCHEMA="lbaw2181" -e DB_USERNAME="lbaw2181" -e DB_PASSWORD="zZMEjYtJ" git.fe.up.pt:5050/lbaw/lbaw2122/lbaw2181
# You can now open https://localhost:8000 to see the web app
```

### 2. Usage

The link to the final product is the following: http://lbaw2181.lbaw.fe.up.pt/  

#### 2.1. Administration Credentials

URL: [Administration](http://lbaw2181.lbaw.fe.up.pt/admin/manageUsers)

| Email | Password |
| -------- | -------- |
| admin@fe.up.pt    | eap!password |

#### 2.2. User Credentials

| Type          | Email   | Password  |
| ------------- | ---------- | --------- |
| basic account | user_test@fe.up.pt   | eap!password |

### Project Management

Ana Luísa Marques, up201907565@up.pt  
Fernando Rego, up2019105951@up.pt  
Margarida Raposo, up201906784@up.pt  
Miguel Amorim, up201907756@up.pt 
