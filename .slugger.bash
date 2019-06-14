
php artisan crud:generate Like --fields="user:integer,slug:string"
php artisan crud:generate Share --fields="shared_on:string,owner:string,sharer:integer,slug:string"
php artisan crud:generate Note --fields="message:string, appreciation:integer,liker:integer"