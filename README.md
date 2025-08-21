<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="200" alt="Laravel Logo"></a></p>

<p align="center"><a href="https://min.io" target="_blank"><img src="https://cdn.prod.website-files.com/681c8426519d8db8f867c1e8/68656cb290ee4fa91989c2dc_Brand-Logo%20%E2%9C%85.svg" width="200" alt="Minio Logo"></a></p>

In this project, I used Minio as AWS s3.

## About Minio
<p><a href="https://min.io" target="_blank">Minio</a> is an open-source distributed object storage server built in Golang.</p>

### Installing Minio Server
According to the original installation guide, you can follow the steps. 
<a href="https://www.min.io/open-source/download?platform=linux&arch=amd64" target="_blank">https://www.min.io/open-source/download?platform=linux&arch=amd64</a>

Here is the ways what I installed on the Linux (Ubuntu). 
Installing minio server in binary

```bash
wget https://dl.min.io/server/minio/release/linux-amd64/minio
```
Changing the file to the excutable mode
```bash 
chmod +x minio 
```

Now we can confirm that Minio server is installed by running.
```bash 
./minio --version 
``` 
But notice, so that you can run `minio`, you have to locate on the directory that `minio` binary file had. So additionally, I gotta move `minio` to the `/urs/local/bin/` directory so that we can run minio from anywhere. To accomplish this, we need to run 

```bash 
sudo mv minio /usr/local/bin 
``` 

Now, calling `minio` on the terminal should work. Just like this
```bash minio --version ```

Alright, let's start the Minio server
```bash
~ » minio server /var/minio --console-address ":9000"
```
> It can conflict with the other addresses 
<p style="color:#fc0324">FATAL Unable to start the server: --console-address cannot be same as --address</p>

If that happened, just use other ports.
```bash
~ » minio server /var/minio --console-address ":9090"
```
No we can create some buckets in minio. For more details check out this article

<a href="https://dev.to/ilyasa1211/laravel-11-use-minio-for-file-storage-as-aws-s3-free-alternative-1bem" target="_blank">https://dev.to/ilyasa1211/laravel-11-use-minio-for-file-storage-as-aws-s3-free-alternative-1bem</a>

## Setting Up
After following the upper steps and cloning the repo, now we can just need to setup some configuration in Laravel.

### Install composer package.
```bash
composer require league/flysystem-aws-s3-v3 "^3.0" --with-all-dependencies
```

### .env
You can also check in `.env.example`.
```
FILESYSTEM_DISK=s3


AWS_ACCESS_KEY_ID=minioadmin
AWS_SECRET_ACCESS_KEY=minioadmin
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=laravel-minio
AWS_USE_PATH_STYLE_ENDPOINT=true
AWS_ENDPOINT="http://127.0.0.1:9000"
AWS_URL="http://127.0.0.1:9000/laravel-minio"
```
Then, make sure you defined s3 disk in `config/filesystems.php`

```php
's3' => [
    'driver' => 's3',
    'key' => env('AWS_ACCESS_KEY_ID'),
    'secret' => env('AWS_SECRET_ACCESS_KEY'),
    'region' => env('AWS_DEFAULT_REGION'),
    'bucket' => env('AWS_BUCKET'),
    'url' => env('AWS_URL'),
    'endpoint' => env('AWS_ENDPOINT'),
    'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
    'throw' => false,
    'report' => false,
]
```
Now, we can store files on s3 just the way we store files before.Far for more information, check out <a target="_blank" href="https://laravel.com/docs/12.x/filesystem">Laravel's File Storage documentation</a>
