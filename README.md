## laravel10-簡易求職平台
``
以laravel10進行全端開發練習，亦有製作API。
開發範圍包含資料表定義、登入登出、權限區分(一般使用者及雇主)、CRUD操作、Email發送及檔案傳輸、多國語言轉換等。
``

---

```shell

# 第一次開啟專案時需先安裝相關套件
npm install
composer install

# 透過artisan產生一組網站專屬密鑰
php artisan key:generate

# 建置資料庫
php artisan migrate:refresh --seed

# 自行去更改.env的資料庫連線資訊

# 啟動tailwindcss
npm run dev

#啟動laravel專案
php artisan server 
```
