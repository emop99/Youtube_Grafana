create table youtube_channel_list
(
    ycl_channel          varchar(250) not null comment '채널 ID'
        primary key,
    ycl_channelName      varchar(100) not null comment '채널명',
    ycl_channelGroupName varchar(25)  null,
    ycl_registDate       datetime     null,
    constraint youtube_channel_list_pk
        unique (ycl_channelName)
)
    comment '유튜브 채널 리스트';

create table youtube_url_list
(
    yul_no              int auto_increment
        primary key,
    yul_ycl_channelName varchar(100)                            null,
    yul_url             varchar(250)                            not null,
    yul_title           varchar(250) collate utf8mb4_unicode_ci null,
    yul_registDate      datetime                                null,
    yul_deleteDate      datetime                                null,
    constraint youtube_url_list_youtube_channel_list_ycl_channelName_fk
        foreign key (yul_ycl_channelName) references youtube_channel_list (ycl_channelName)
)
    comment '크롤링 대상 URL List';

create table youtube_views_log
(
    yvl_no         int auto_increment
        primary key,
    yvl_yul_no     int              null,
    yvl_views      bigint default 0 null,
    yvl_registDate datetime         null,
    constraint youtube_vies_log_youtube_url_list_yul_no_fk
        foreign key (yvl_yul_no) references youtube_url_list (yul_no)
)
    comment '유튜브 조회수 로그';

create index youtube_views_log_yvl_registDate_index
    on youtube_views_log (yvl_registDate);

