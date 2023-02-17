# JWT操作类库

### composer 引入方法
修改composer.json文件，在autoload项，添加如下配置。路径"app/Library/josejwt"可以自由定义
```
{
    "name": "lhzptg/jose-jwt",
    "autoload": {
        "psr-4": {
            "josejwt\\": "app/Library/josejwt",  //定义“josejwt”类库存放路径./app/Library/josejwt，该路径可以自由定义
        }
    }
}
```


### 使用实例：
```
use josejwt\xbull\josejwt;

$JWT = new josejwt();
$this->jwt = $JWT->verifyIdToken($idtoken, $publickey);
```

