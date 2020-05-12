# WeatherForecast
毎日指定した時間に天気情報を送信するなにか

## 使い方
まず起動したら
cityid 県名をうち、番号を調べます(自分の住んでいるところに一番近い市を選ぶ)
番号を調べたら
signup line lineのuserID(※1) cityid\n
か
signup discord webhookURL cityid
を打ち、送信先を設定します
尚コマンドがわからなくなった場合はhelpと打てばすべて出てきます

lineのMessaging-APIを使用する場合、
起動したあとに、data/userData/setting.txtというファイルが生成されます
そのファイルの中にChannelAccesstToken: XXXという形でチャネルアクセストークンを入力して保存してください

※1 lineのuserIDについてはlineのMessaging-APIで取得したuserIDを入力してください
