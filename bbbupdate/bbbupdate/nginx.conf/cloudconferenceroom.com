#a You may add here your
# server {
#	...
# }
# statements for each of your virtual hosts

server {
	listen   80;
	server_name  cloudconferenceroom.com www.cloudconferenceroom.com;
	
	client_body_timeout 160;
	client_header_timeout 160;
	send_timeout 160;
	client_max_body_size 10m;
	log_not_found off;

	access_log  /var/log/nginx/cloudconference.access.log;

	location / {
		root   /home/access123/public_html;
		index  index.html index.htm index.php;
	}

	# /client is an app of Cakephp
	#
	location /yii {
		deny all;
	}

	location /client {
		root	/home/access123/public_html/client/app/webroot;
    		index	index.php;
		rewrite     ^/client$ /client/ permanent;
    		rewrite     ^/client/(css/.+)$ /$1 break;
		rewrite	    ^/client/(img/.+)$ /$1 break;
		rewrite	    ^/client/(js/.+)$ /$1 break;
		rewrite     ^/client/(files/.+)$ /$1 break;
                rewrite	    ^/client/(image/.+)$ /$1 break;
                rewrite     ^/client/(flash/.+)$ /$1 break;
    		rewrite     ^/client(.+)$ /client/app/webroot/index.php?url=$1 last;
	}

	#include /etc/nginx/common/cake;

	#location /doc {
	#	root   /usr/share;
	#	autoindex on;
	#	allow 127.0.0.1;
	#	deny all;
	#}

	#location /images {
	#	root   /usr/share;
	#	autoindex on;
	#}

	#error_page  404  /404.html;

	# redirect server error pages to the static page /50x.html
	#
	#error_page   500 502 503 504  /50x.html;
	#location = /50x.html {
	#	root   /var/www/nginx-default;
	#}

	# proxy the PHP scripts to Apache listening on 127.0.0.1:80
	#
	#location ~ \.php$ {
		#proxy_pass   http://127.0.0.1;
	#}

	# pass the PHP scripts to FastCGI server listening on 127.0.0.1:9000
	#
	location ~ \.php$ {
		fastcgi_pass   127.0.0.1:9000;
		fastcgi_index  index.php;
		fastcgi_param  SCRIPT_FILENAME  /home/access123/public_html$fastcgi_script_name;
		include fastcgi_params;
	}

	# deny access to .htaccess files, if Apache's document root
	# concurs with nginx's one
	#
	#location ~ /\.ht {
		#deny  all;
	#}
}


# another virtual host using mix of IP-, name-, and port-based configuration
#
#server {
#listen   8000;
#listen   somename:8080;
#server_name  somename  alias  another.alias;

#location / {
#root   html;
#index  index.html index.htm;
#}
#}


# HTTPS server
#
#server {
#listen   443;
#server_name  localhost;

#ssl  on;
#ssl_certificate  cert.pem;
#ssl_certificate_key  cert.key;

#ssl_session_timeout  5m;

#ssl_protocols  SSLv2 SSLv3 TLSv1;
#ssl_ciphers  ALL:!ADH:!EXPORT56:RC4+RSA:+HIGH:+MEDIUM:+LOW:+SSLv2:+EXP;
#ssl_prefer_server_ciphers   on;

#location / {
#root   html;
#index  index.html index.htm;
#}
#}
