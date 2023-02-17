# JWT操作类库

### composer 引入方法
修改composer.json文件，在autoload项，添加如下配置。路径"app/Library/xbull\josejwt"可以自由定义
```
{
    "name": "lumen-test",
    "autoload": {
        "psr-4": {
            "xbull\josejwt\\": "app/Library/xbull\josejwt",  //定义“xbull\josejwt”类库存放路径./app/Library/xbull\josejwt，该路径可以自由定义
        }
    }
}
```
### feature-TP3.2
此分支，适用与TP3.2版本，可以直接放入目录：PrimarySchool\ThinkPHP\Library\xbull\josejwt
由于TP3.2的类库必须以.class.php为后缀。因此所有文件都添加了该后缀。


### 使用实例：
```
use xbull\josejwt\xbull\josejwt;

$JWT = new xbull\josejwt();
$this->jwt = $JWT->verifyIdToken($idtoken, $publickey);
```

