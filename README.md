# Web Tabanli Programlama Özer Market
 PHP, MySQL, Html, BootStrap kullanılarak yapılmış web tabanlı uygulamadır. Bu projede bir sanal market oluşturdum. Projemi anlatmaya yetkilerden bahsederek başlamak istiyorum.
 3 adet yetki vardır. Bunlar "admin" "personel" ve "üyedir". Admin sisteme giriş yapan kullanıcıların yetkilerini değiştiribilmektedir. Personel ürün kategorisi ekleyip bunları düzenleyebilir. Ürün ekleyip bu ürünleri düzenleyebilmektedir. Son yetki iste üyedir. Üyeler menüsünde ürünler ve sepet vardır. Şuanlık ürünleri görebilir ancak alışveriş yapamaktayız.
Admin ve personel sadece ürünleri ve bilgilerini görebilirken üyeler ürünlerin altına almak istediği kadar adet bilgisi girebilir ve sepete ekle butonuyla sepete ekleyebilir. 
<br><br>

## Web Sitesinde Denenebilir Hesaplar
!!! Hazır web sitesine girilmiş hesap bilgileri aşağıdadir. Canlı bir şekilde deneyimleyebilirsiniz. <br>

kullanıcı adı: admin<br>
şifre : 1

kullanıcı adı: personel <br>
şifre : 123

kullanıcı adı: üye<br>
şifre : 123<br>


## Eklenecek Özellikler
- Satın alma fonksiyonu eklenecek.
- Satın alınan öğeleri görebileceğimiz bir sepet eklenecek.
- Geçmiş satın alımları profilimizde görebileceğimiz bir sayfa eklenecek.
- Satın alıma bağlı olarak ürün stoklarında azalma eklenecek.

<br>

## Sitenin linki 
http://erenmarket.erenozer.com.tr
<br> <br>

## Anlatım Videosu
https://youtu.be/BevtXefWAYY <br><br>


## Gereksinimler

- XAMPP (PHP ve MySQL desteği ile)
- Bir web tarayıcısı <br><br>


## Kurulum

### 1. XAMPP Kurulumu

1. [XAMPP](https://www.apachefriends.org/index.html) indirin ve kurun.
2. XAMPP Kontrol Panelini açın ve Apache ile MySQL servislerini başlatın.<br>

### 2. Proje Dosyalarını İndirin

1. Bu projeyi zip olarak indirin.
2. XAMPP'ın `htdocs` dizinine gidin ve `proje` adında bir klasör açın.
3. Proje dosyalarını `proje` adlı dosyaya aktarın.<br>
 
### 3. Veritabanı Kurulumu

1. Tarayıcınızdan phpMyAdmin'i açın.
2. Yeni bir veritabanı oluşturun ve ismini `webproje` yapın.
3. `webproje.sql` dosyasını bu veritabanına içe aktarın:
    - phpMyAdmin arayüzünden `Import` sekmesine gidin.
    - `webproje.sql` dosyasını seçin ve içe aktarın.<br>

### 4. Başlatma

1. Tarayıcınıza `http://localhost/proje` yazın.
2. Artık kullanabilirsiniz.

### 5. Admin girişi
1. Kendi kuracağınız uygulama için geçerlidir.
2. Admin girişi önceden belirlenmiştir.
3. kullanıcı adı: `admin` / şifre: `1`'dir.
4. Eğer personel girişini kullanmak istiyorsunuz giriş yapmış bir üyeyi admin yetkisiyle üye yetkisini personele çevirmeniz gerekmektedir.
