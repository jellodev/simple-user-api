# user API 1.0
[개발환경]
* Docker Container (mysql + nginx + php) 
* Codeigniter 4 
* Mac OS 

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
**API 기본정보**
메서드 | 요청 URL | 출력 포맷 | 설명 
-- | --  |  -- | -- 
`GET` `POST` | http://localhost:18080/user/geybyid | JSON | 아이디로 단일회원 상세 정보 조회  

**REQUEST**
필드 | 타입 | 필수 여부 | 설명 | 기본값 | 기타
-- | -- | -- | -- | -- | -- 
id | Integer | Y | 사용자 고유 아이디 |  |  

**RESOPONSE 예**
```json
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

## user/fetch 
**API 기본정보**
메서드 | 요청 URL | 출력 포맷 | 설명 
-- | --  |  -- | -- 
`GET` `POST`| http://localhost:18080/user/fetch | JSON | 여러 회원 목록 정보 조회  | 

**REQUEST**
필드 | 타입 | 필수 여부 | 설명 | 기본값 | 기타 
-- | -- | -- | -- | -- | -- 
name | String | N | 회원 이름 | |
email | String | N | 회원 이메일 | | 
limit | Int | N | 한번 조회 시 가져올 회원정보 로우의 갯수 | 1000 | 
offset | Int | N | 앞서 생략할 회원정보 회원정보 로우의 갯수 | 0 | 

**RESOPONSE 예**
```json
[
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
        "nickname": "mihee2",
        "password": "$2y$10$yKkR9658dnK6iFvjeybX6eNlG2OIaCe414/Lr1JlGOdHCtaozn98G",
        "tel": "01022341234",
        "email": "test2@mail.com",
        "gender": "F",
        "creationtime": "2020-04-23 21:11:33"
    }
]
```

## user/create
**API 기본정보**
메서드 | 요청 URL | 출력 포맷 | 설명 
-- | --  |  -- | -- 
`GET` `POST`| http://localhost:18080/user/create  | JSON |  신규 회원정보 생성하기 

**REQUEST**
필드 | 타입 | 필수 여부 | 설명 | 기본값 | 기타
-- | -- | -- | -- | -- | -- 
name | String | Y | 이름 | | 최대 길이 20자, 한글, 영문 대소문자  
nickname | String | Y | 별명 | | 최대 길이 30자, 영문 소문자 
password | String | Y | 비밀번호 | | 최소 길이 10자, 영문 대문자, 영문 소문자, 특수문자, 숫자 각 1개 이상씩 포함
email | String | Y | 이메일 | | 최대 길이 100자
tel | String | Y | 전화번호 | | 최대 길이 20자
gender | String | N | 성별 | |  최대 길이 1자, 'F' or 'M' 값외에는 빈값처리 

**RESOPONSE 예**
```json
{"status":"success","messages":"create new user. id: 3"}
```

## user/login 
**API 기본정보**
메서드 | 요청 URL | 출력 포맷 | 설명 
-- | --  |  -- | -- 
`GET` `POST`| http://localhost:18080/user/lgoin   | JSON | 회원 로그인(인증)

**REQUEST**
필드 | 타입 | 필수 여부 | 설명 | 기본값 | 기타 
-- | -- | -- | -- | -- | --
email | String | Y | 이메일 | | 
password | Stirng | Y | 비밀번호 | |

**RESOPONSE 예**
```json
{"status":"success","accessToken":"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJtaWhlZSIsInN1YiI6IjMiLCJpYXQiOjE1ODc2NzcxNjgsImV4cCI6MTU4NzY4MDc2OH0.v1t5tkYVdQ2XMN2fpM-xCSyzcr0pw0r0CSGJ4jIdo0M","tokenType":"Bearer","expireTime":1587680768}
```

## user/logout
**API 기본정보**
메서드 | 요청 URL | 출력 포맷 | 설명 
-- | --  |  -- | -- 
`GET` `POST`| http://localhost:18080/user/logout  | JSON |  회원 로그아웃 

**REQUEST**
요청 헤더
요청 헤더명 | 설명 
-- | -- 
Authorization | 접근 토큰(access token)을 전달하는 헤더

요청 헤더 예
```json
Authorization: eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJtaWhlZSIsInN1YiI6IjMiLCJpYXQiOjE1ODc2NzcxNjgsImV4cCI6MTU4NzY4MDc2OH0.v1t5tkYVdQ2XMN2fpM-xCSyzcr0pw0r0CSGJ4jIdo0M
```

**RESOPONSE 예**
```json
{"status":"success","message":"logout"}
```

### user/token/refresh
**API 기본정보**
메서드 | 요청 URL | 출력 포맷 | 설명 
-- | --  |  -- | -- 
`GET` `POST`| http://localhost:18080/user/token/refresh | JSON | accesstoken 갱신 

**REQUEST**
요청 헤더
요청 헤더명 | 설명 
-- | -- 
Authorization | 접근 토큰(access token)을 전달하는 헤더

요청 헤더 예
```
Authorization: eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJtaWhlZSIsInN1YiI6IjMiLCJpYXQiOjE1ODc2NzcxNjgsImV4cCI6MTU4NzY4MDc2OH0.v1t5tkYVdQ2XMN2fpM-xCSyzcr0pw0r0CSGJ4jIdo0M
```

**RESOPONSE 예**
```json
{
    "status": "success",
    "accessToken": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJtaWhlZSIsInN1YiI6IjUiLCJpYXQiOjE1ODc3MTA2ODksImV4cCI6MTU4NzcxNDI4OX0.OJ6mn-kbWDDY4NAQMWAzXvC-Fut3gCOQXQowZYWg5MM",
    "tokenType": "Bearer",
    "expireTime": 1587714289
}
```

## Test 
postman 이용
[postman collection json](../bpker.postman_collection.json) 

