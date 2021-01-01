1. mysql사용시 table을 생성해야 한다면 다음을 사용한다

create table news(
n_idx integer NOT NULL AUTO_INCREMENT PRIMARY KEY,
url varchar2(250),
title varchar2(200),
day date,
);

create table keyword(
rank integer,
word varchar2(30),
day date,
);
******************************
2. 크론탭(crontab)을 실행해 자동으로 크롤링하게 함.

0 */6 * * * /usr/bin/wget http://cspro.sogang.ac.kr/~cse20140400/cgi-bin/Crawling.php
5 12 * * * /usr/bin/wget http://cspro.sogang.ac.kr/~cse20140400/cgi-bin/Crawling.php

