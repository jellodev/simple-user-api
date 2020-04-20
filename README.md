# user API 1.0b 

* 모든 API는 POST,GET Method를 지원함 
* parameter 명에 M으로 표기되어있는 항목은 필수값

## Getting Started
### Prerequisties 
Required | Description
-- | -- 
[Docker] (https://www.docker.com/) | latest version 
[CodeIgnaiter4] (https://codeigniter.com/) | latest version 
[compose 파일] (https://phpdocker.io/generator) | docker compose file 생성 

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
### user/get
진행중

### user/fetch 
진행중

### user/login 
진행중

### user/logout
진행중

## Test 
API 테스트방법 ... 
postman 이용중 



