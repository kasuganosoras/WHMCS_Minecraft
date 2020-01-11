# WHMCS_Minecraft
WHMCS Hook Minecraft Services

一个可以实现付费执行指定命令的 WHMCS 模块，可用于 Minecraft 服务器 VIP 自动化开通、游戏自动充值等。

## 插件需要
- 支持 Rcon 的 Minecraft 服务器 * 1，例如 Spigot，PaperSpigot，Thermos 等
- 一个 WHMCS（废话）

## Rcon 开启方法
1. 编辑 MC 服务器配置文件 `server.properties`
2. 找到 `enable-rcon=`，把 false 改为 true（如果没有就自己加一行）
3. 在结尾新增两行：
   ```ini
   rcon.port=RCON 运行端口（自己改）
   rcon.password=RCON 连接密码（自己改）
   ```
4. 重启服务器

## 本模块安装方法

1. 将本项目 clone 或者下载 zip 到本地，将项目文件夹放入 `WHMCS/modules/servers/` 中，并重命名为 `minecraft`
2. 进入你的 WHMCS 后台，添加新产品，接口设置选择 `minecraft`
3. 填写你的 MC 服务器 IP、你设置的 Rcon 端口以及密码，然后在 __首次开通执行命令__ 输入框中填写开通后会执行的游戏命令
4. 继续填写其他输入框或者保存产品配置，选择 __付款后立即自动开通__ 或者 __手动审核通过后自动开通__
5. 转到产品的 __客户自定义区域__ 页面并新增一项：
   - 区域名称：游戏名字
   - 区域类型：文本框
   - 描述：这里随便填写什么都行
   - 验证：`/^[A-Za-z0-9\_\-]{1,16}$/`
   - 勾选：必填、在订购产品时显示
6. 保存设置，尝试购买，并查看游戏后台是否有效果

## 开源协议
本项目使用 MIT 协议开源
