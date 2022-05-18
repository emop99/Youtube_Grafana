# Youtube_Grafana

## 우왁굳 & 이세계 아이돌 조회수 크롤링 데이터 시각화하기
- 우왁굳 조회수 - http://grafana.emop.kro.kr/d/9J3b_j_nk/uwaggud-yutyubeu-johoesu-rogeu?orgId=2
- 이세계 아이돌 조회수 - http://grafana.emop.kro.kr/d/kljfo12a/isegyeaidol-yutyubeu-johoesu-rogeu?orgId=2

## Logic
1. youtube_channel_list 테이블에 채널을 등록
2. 1분 마다 youtube_channel_list 등록된 채널 크롤링 & 새로운 영상 youtube_url_list 테이블에 Insert
3. 5분 마다 youtube_url_list 등록된 영상들 조회수 정보 크롤링 & youtube_views_log 테이블에 Insert

## Table 구조
![tableStruct.png](img/tableStruct.png)

## Screen
![img.png](img/woowakgoodScreen.png)
![img.png](img/IsegyeIdolScreen.png)