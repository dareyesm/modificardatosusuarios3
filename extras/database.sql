create table if not exists users(

idUsers INT unsigned not null auto_increment,
loginUsers VARCHAR(15) character set utf8 collate utf8_spanish_ci not null,
passUsers VARCHAR(10) character set utf8 collate utf8_spanish_ci not null,
idprofile INT not null,
emailUser VARCHAR(50) character set utf8 collate utf8_spanish_ci not null,
idActiveCode VARCHAR(500) character set utf8 collate utf8_spanish_ci,
path_imgUser LONGTEXT character set utf8 collate utf8_spanish_ci,
idexistindb INT not null,
status set('Disabled', 'Enabled'),
primary key(idUsers)

)engine=myisam character set utf8 collate utf8_spanish_ci;

create table if not exists profiles(
	idProfile INT unsigned not null auto_increment,
	nameProfi varchar(10) character set utf8 collate utf8_spanish_ci,
	primary key(idProfile)
)engine=myisam character set utf8 collate utf8_spanish_ci;

create table if not exists user_data(

id_data INT unsigned not null auto_increment,
names VARCHAR(250) character set utf8 collate utf8_spanish_ci,
bornin DATE not null,
country VARCHAR(50) character set utf8 collate utf8_spanish_ci, 
city VARCHAR(50) character set utf8 collate utf8_spanish_ci,
idUsers INT not null,
constraint fk1 foreign key(idUsers) references users(idUsers),
primary key(id_data)

)engine=myisam character set utf8 collate utf8_spanish_ci;