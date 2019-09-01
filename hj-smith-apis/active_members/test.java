public class Main{
    public static void main(String[] args){
        System.out.println("Hey");
    }
}

server {
    listen 443;
    server_name secsoftinc.com;

    location / {
        proxy_set_header   X-Forwarded-For $remote_addr;
        proxy_set_header   Host $http_host;
        proxy_pass         http://31.220.58.20:1234;
    }
}
}