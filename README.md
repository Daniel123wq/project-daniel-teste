## Solução para processo seletivo resolvida em Laravel v8
Api responsável pela solução do problema do processo seletivo.

# ENDPOINT
https://dasdrasys.com.br/projeto-daniel-teste

A documentação você pode encontrar aqui: https://documenter.getpostman.com/view/5610670/UV5f7Dvr

## Para instalar o projeto
```
composer install 
composer dump-autoload
```

## Para executar
- Deve copiar o .env.example e configurar o ambiente assim como o banco de dados
```
php artisan migrate
php artisan key:generate
php artisan serve
```

# Caso ocorra error
```
php artisan config:clear
php artisan cache:clear
```
