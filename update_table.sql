ALTER TABLE pengajuan_inbox
add column Catatan varchar(100)

alter table pengajuan
add column warga_id bigint,
add constraint fk_pengajuan_to_warga foreign key(warga_id)
references  warga(id) match simple
on update no ACTION
on delete no ACTION,
add column created_by bigint,
add CONSTRAINT fk_pengajuan_to_warga2 foreign key(created_by)
REFERENCES warga(id) match simple
on update no ACTION
on delete no action;

create table notifikasi(
	id bigint AUTO_INCREMENT primary key,
    dari_warga_id bigint not null,
    untuk_warga_id bigint not null,
    url varchar(255),
    pesan text,
    constraint fk_notification_from_warga foreign key(dari_warga_id)
    references warga(id) match simple
    on update no ACTION
    on delete no action,
    constraint fk_notification_to_warga FOREIGN key(untuk_warga_id)
    REFERENCES warga(id)
    on update no action
    on delete no action
)

<<<<<<< HEAD
ALTER TABLE `pengajuan` CHANGE `no_ktp` `no_ktp` BIGINT(16) NOT NULL; 
=======
alter table notifikasi
add column status varchar(20) default 'new'

alter table notifikasi
add column tanggal date default null

alter table warga add column tanggal_dibuat timestamp default CURRENT_TIMESTAMP
>>>>>>> 91fb350ac4dfd7014d7137f4ad7edd689e422624
