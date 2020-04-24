# user API 1.0
[개발환경]
* Docker Container (mysql + nginx + php) 
* Codeigniter 4 
* Mac OS 

👉 [테이블 생성 쿼리문](../master/Mysql_User.sql) 

## Getting Started
  
### docker 환경 셋팅 
1. 프로젝트 root 폴더에 codeignaiter.zip 압축 풀기
2. 프로젝트 root 폴더에 phpdocker.zip 압출 풀기 

```
$ cd /phpdocker/php-fpm/php-ini-override.ini
$ nano php-ini-override.ini
```
3. ini 파일에 설정 추가하기 
```
date.timezone = Asia/Seoul
short_open_tag = On
```
3. 프로젝트 root 폴더에서 docker compose 실행하여 컨테이너 생성
```
$ docker-compose up -d
```
## user/get
아이디로 단일회원 상세 정보 조회  

* **URL**  
http://localhost:18080/user/getbyid

* **Method:**  
`GET` | `POST`

* **Params**   
  **Required:**  
    `id=[Integer]`    
    
  **Optional:**   
  
* **Success Response:**
    ```json
    {
        "status": "success",
        "user": {
            "id": "3",
            "name": "안자요",
            "nickname": "mihee",
            "password": "$2y$10$TM8oYiQHoXF3Zbrab346ZO3pKkhzmBWLqd6NBmBILOUzxHvbCBMT.",
            "tel": "01022341234",
            "email": "test3@mail.com",
            "gender": "F",
            "creationtime": "2020-04-23 21:26:03"
        }
    }
    ``` 
* **Error Response:** 
    ```json
    {
        "status": "error",
        "messages": "Undefined index: id"
    }
    ```
    OR 
     ```json
     {
        "status": "error",
        "messages": "Not Found"
     }
     ```


## user/fetch 
여러 회원 목록 정보 조회

* **Url**   
http://localhost:18080/user/fetch

* **Method**  
`GET` | `POST`  

* **Params**   
    **Required:**  

    **Optional:**  
        `name=[Stinrg]`  
        `email=[String]`  
        `limit=[Integer]` //기본값 1000  
        `offset=[Integer]`  //기본값 0  

* **Success Response:**
    ```json
    {
        "status": "success",
        "users": [
            {
                "id": "1",
                "name": "mihee",
                "nickname": "mihee",
                "password": "$2y$10$Wur5AddUJHWj8eghSz2dyu8LXHudFicNdrUC50B/4xwU573jO/hoK",
                "tel": "01022341234",
                "email": "test1@mail.com",
                "gender": "M",
                "creationtime": "2020-04-23 21:09:23"
            },
            {
                "id": "2",
                "name": "안자요",
                "nickname": "mihee",
                "password": "$2y$10$yKkR9658dnK6iFvjeybX6eNlG2OIaCe414/Lr1JlGOdHCtaozn98G",
                "tel": "01022341234",
                "email": "test2@mail.com",
                "gender": "F",
                "creationtime": "2020-04-23 21:11:33"
            }
        ]
    }
        ```
* **Error Response:** 
    ```json
    {
        "status": "error",
        "messages": "Not Found"
    }
    ```


## user/create
신규 회원정보 생성하기 
* **Url**  
http://localhost:18080/user/create  

* **Method:**  
`GET`| `POST`

* **Params**  
    **Required:**  
        `name=[String]` //최대 길이 20자, 한글, 영문 대소문자  
        `nickname=[String]`//최대 길이 30자, 영문 소문자  
        `password=[String]` //최소 길이 10자, 영문 대문자, 영문 소문자, 특수문자, 숫자 각 1개 이상씩 포함  
        `email=[String]` //최대 길이 100자  
        `tel=[Integer]` //최대 길이 20자  
        
    **Optional:**  
        `gender=[String]` //최대 길이 1자, ‘F’ or ‘M’ 값외에는 빈값처리  

* **Success Response:**  
    ```json
    {
        "status": "success",
        "messages": "create new user. id: 6"
    }
    ```
* **Error Response:** 
    ```json
    {
        "status": "error",
        "messages": "invalid request"
    }
    ```
    OR 
    ```json    
    {
        "status": "error",
        "messages": {
            "name": "The name field is not in the correct format.",
            "nickname": "The nickname field is not in the correct format.",
            "password": "The password field is not in the correct format.",
            "email": "The email field must contain a unique value.",
            "tel": "The tel field must only contain digits and must be greater than zero.",
            "gender": "The gender field is not in the correct format."
        }
    }  
    ``` 
    
## user/login 
회원 로그인(인증)

* **Url**   
    http://localhost:18080/user/lgoin 
    
* **Method:**   
    `GET`| `POST`  
* **Params**  
    **Required:**  
        `email=[String]`  
        `password=[String]` 
        
    **Optional:**  
* **Success Response:**  
    ```json
    {
        "status": "success",
        "accessToken": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJtaWhlZSIsInN1YiI6IjUiLCJpYXQiOjE1ODc3MTUzMTEsImV4cCI6MTU4NzcxODkxMX0.8lvtDRrHpazSGH6UWdM0NeVHz9xSrwNZnqeYsItLeJU",
        "tokenType": "Bearer",
        "expireTime": 1587718911
    }
    ```  
* **Error Response:** 
    ```json
    {
        "status": "error",
        "messages": "Not Found"
    }
    ```


## user/logout
회원 로그아웃
* **Url**     
http://localhost:18080/user/logout 

* **Method:**   
`GET`|`POST`  
* **Header**
    `Authorization=접근 토큰(access token)을 전달하는 헤더`  

    **요청 헤더 예**
    ```
    Authorization: eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJtaWhlZSIsInN1YiI6IjMiLCJpYXQiOjE1ODc2NzcxNjgsImV4cCI6MTU4NzY4MDc2OH0.v1t5tkYVdQ2XMN2fpM-xCSyzcr0pw0r0CSGJ4jIdo0M
    ```
* **Success Response:**
    ```json
    {
        "status": "success",
        "message": "logout"
    }
    ```
* **Error Response:** 
    ```json
    {
        "status": "error",
        "messages": "Authentication failed"
    }
    ```
    
## user/token/refresh
accesstoken 갱신 
* **Url**  
http://localhost:18080/user/token/refresh

* **Method:**   
`GET`|`POST` 

* **Header**
    `Authorization=접근 토큰(access token)을 전달하는 헤더`

    **요청 헤더 예**
    ```json
    Authorization: eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJtaWhlZSIsInN1YiI6IjMiLCJpYXQiOjE1ODc2NzcxNjgsImV4cCI6MTU4NzY4MDc2OH0.v1t5tkYVdQ2XMN2fpM-xCSyzcr0pw0r0CSGJ4jIdo0M
    ```
* **Success Response:**
    ```json
    {
        "status": "success",
        "accessToken": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJtaWhlZSIsInN1YiI6IjUiLCJpYXQiOjE1ODc3MTA2ODksImV4cCI6MTU4NzcxNDI4OX0.OJ6mn-kbWDDY4NAQMWAzXvC-Fut3gCOQXQowZYWg5MM",
        "tokenType": "Bearer",
        "expireTime": 1587714289
    }
    ```
* **Error Response:** 
    ```json
    {
        "status": "error",
        "messages": "Authentication failed"
    }
    ```

## Test 
postman 이용
[postman collection json](../master/bpker.postman_collection.json) 



