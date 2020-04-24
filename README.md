# user API 1.0
[개발환경]
Docker Container (mysql + nginx + php) 
Codeigniter 4 
Mac OS 

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
## API 기본정보 

### user/get
메서드 | 요청 URL | 출력 포맷 | 설명 
-- | --  |  -- | -- 
GET/POST | http://localhost:18080/user/geybyid | JSON | 아이디로 단일회원 상세 정보 조회  

[REQUEST]
필드 | 타입 | 필수 여부 | 설명
-- | -- | -- | --
id | Integer | Y | 사용자고유아이디 

[RESOPONSE 예]
```
{
    "id": "1",
    "name": "mihee",
    "nickname": "mihee",
    "password": "$2y$10$Wur5AddUJHWj8eghSz2dyu8LXHudFicNdrUC50B/4xwU573jO/hoK",
    "tel": "01022341234",
    "email": "test1@mail.com",
    "gender": "M",
    "creationtime": "2020-04-23 21:09:23"
}
```

### user/fetch 
메서드 | 요청 URL | 출력 포맷 | 설명 
-- | --  |  -- | -- 
GET/POST | http://localhost:18080/user/fetch | JSON | 여러 회원 목록 정보 조회  

[REQUEST]
필드 | 타입 | 필수 여부 | 설명
-- | -- | -- | --
name | String | N | 회원 이름 
email | String | N | 회원 이메일
limit | Int | N | 한번 조회 시 가져올 로우의 갯수 (10을 지정하면 10개의 회원정보 row를 가져옴)
offset | Int | N | 앞서 생략할 회원정보 로우의 갯수 (10을 지정하면 앞의 10개의 회원정보 row는 생략하고 11번째 회원정보 row부터 가져옴)

[RESOPONSE]
```
```

### user/create
메서드 | 요청 URL | 출력 포맷 | 설명 
-- | --  |  -- | -- 
GET/POST | http://localhost:18080/user/create  | JSON |  신규 회원정보 생성하기 

[REQUEST]
필드 | 타입 | 필수 여부 | 설명
-- | -- | -- | --

[RESOPONSE]
```
```

### user/login 
메서드 | 요청 URL | 출력 포맷 | 설명 
-- | --  |  -- | -- 
GET/POST | http://localhost:18080/user/lgoin   | JSON | 회원 로그인(인증)

[REQUEST]
필드 | 타입 | 필수 여부 | 설명
-- | -- | -- | --

[RESOPONSE]
```
```

### user/logout
메서드 | 요청 URL | 출력 포맷 | 설명 
-- | --  |  -- | -- 
GET/POST | http://localhost:18080/user/logout  | JSON |  회원 로그아웃 

요청 헤더
요청 헤더명 | 설명 
-- | -- 
Authorization | 접근 토큰(access token)을 전달하는 헤더

요청 헤더 예
```
Authorization: eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJtaWhlZSIsInN1YiI6IjMiLCJpYXQiOjE1ODc2NzcxNjgsImV4cCI6MTU4NzY4MDc2OH0.v1t5tkYVdQ2XMN2fpM-xCSyzcr0pw0r0CSGJ4jIdo0M
```
[REQUEST]
필드 | 타입 | 필수 여부 | 설명
-- | -- | -- | --

[RESOPONSE]
```
```

#### user/token/refresh
메서드 | 요청 URL | 출력 포맷 | 설명 
-- | --  |  -- | -- 
GET/POST | http://localhost:18080/user/token/refresh | JSON | accesstoken 갱신 

[REQUEST]
필드 | 타입 | 필수 여부 | 설명
-- | -- | -- | --

[RESOPONSE]
```
```

## Test 
API 테스트방법 ... 
postman 이용중 



