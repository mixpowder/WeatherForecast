# WeatherForecast
毎日指定した時間に天気情報を送信するなにか

## 使い方
まず起動したら
cityid 県名をうち、番号を調べます(自分の住んでいるところに一番近い市を選ぶ)
番号を調べたら
signup line lineのuserID(※1) cityid
か
signup discord webhookURL cityid
を打ち、送信先を設定します
尚コマンドがわからなくなった場合はhelpと打てばすべて出てきます

送信先をlineに設定する場合、
起動したあとに、data/userData/setting.txtというファイルが生成されます
そのファイルの中にChannelAccesstToken: XXXという形で使用するbotのチャネルアクセストークンを入力して保存してください

送信時間を設定したい場合、上と同じくdata/userData/setting.txtというファイルの中のTime: 6:00という部分を変えてください
初期設定では6時に送信になっています
設定例
Time: 19:01 7時1分に送信などなど

で注意なのがファイルを操作した場合必ず再起動してください
しなければ設定が反映されません

※1 lineのuserIDについてはlineのMessaging-APIで取得したuserIDを入力してください

※2 使用している天気APIの都合上その日のデータが取得できない場合があります　なので使用したい場合は事前に起動したほうがいいかと思います
