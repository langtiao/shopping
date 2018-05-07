<?php
$config = array (	
		//应用ID,您的APPID。
		'app_id' => "2016091500520863",

		//商户私钥
		'merchant_private_key' => "MIIEowIBAAKCAQEA26sBqNOfyi2r++XLkFFZU16iRHJmjgq0+KQn
		Tka2p2UyufMFGsJsXDu8CTSngK2MGW6xZED+BiAruIgcRCzjMK1XgKPFgrN0u3lUw0mW8xxZH1/
		ok9XFZVCjh6wyVGobbJWj3sc/wYkJe44isqZMMOEnrCKjrZTkrmEbe6AlU81HPX+qJnJQqLK6GTleF+
		pHUXnMvsf8CEkCO4LpAHyo/TM3q9pRps+7rt5qDPYON+hUUSF/z8xwcMknChBjgO8AJlJc3W1hGsheYuJVe
		FucU1sk6vLgPQkLCHENgY/Rlse752nWvQOW5409sWoAv7KzqWdfXD5Ix0YPpQ8fKtH3pwIDAQABAoIBAA80
		LtE4lH6x2o18wjIi70PN8P07zc1XAF+VPQM18b50SqaEI35OpqFboRAiDNXjLSc1eiGuPea+o0gKY6p0UOU1m
		jDVJP5+3T18kFlT5pa9B44cXUSeLyNsCWWCjZk6HtvNH6Jzt/31NirPE6e5ytw3OT+4xgtlms5W+kf8NZkvI0Mt
		qQJEhoGcpdnovHRsA74V24QZ3iiSbNK2jLiwYF1jo/PF+3vwdKYTiW1us47dr3V7I+ivpEg7KAPbcBw/
		WvgxJI+GqAh6HpDq77lW8GxojCNSz0dXtgInuGAi4tCAi/Lc0/CGSBL95VA11AjIIwKSVNUXX5J/
		Xahd4IxAlcECgYEA71Dna4w/u9EwMX9cumm+jc/cHYdYxvxAiCOQYxJBrj6ffDlArwlkuSjA0x+Ktd+h
		PitAqWiwFBGUM2fEkxVyUZjRXMmXyrWGmlkyuUAqEGjScgRwsrcklD74fmonVUUYK6mPVKJCS15dBYpru
		P7sYW2pWfM0zGeaOgKS0t0nvnUCgYEA6vtxLeaj3S/TYdqBh2Vz9Ii/6HJG5XIJ+nsWOTf9EIrhUHm3Bkmr
		FuyYbOIf44s6Fmu2xQek4nls7Hc1d34HVhWf4rE52F0CKIz8x8YKKqeoRd7kdTCdumgTR8M+x/rO6szvWEO3VAr
		iF8BTX8LL+gnGohzypc5ZM4/GStQl0isCgYBw+yUGJSRBqzSxaYuBhkKr+KHWXvuOlbBxl
		TipTQktFet9XhoniKvArni6M33s9zLMgub4E7BtCQ+KZUbsmYdq9laBE7tRu/lcDRhhVOWG8bXIlkgOV2Axj
		LkMFVmUbBZJJrfAIQpjQp1v7DWHFPLL3FXDXYpjpdWt5WEjo70LsQKBgQDF+t3r74QmivINYx15J1h
		gMouGXCoxjTitCuG5idu1AV4/AJ3dNVpqMSNnscluXNKvK0fNj9gzXF0SionIyK2DsSqJxApZqlt0MP2Vj9zm/
		WVAoUBZIIH0GVYNQ4p00XNezxXlhwBCVf0SR9+3MhfL7kqmMb+bRVVQpRVL3JyVCwKBgB/cHH02nCWpvCSTFOmQz812byl
		LIUM+NH96hIIFk9tnUF56OSbT//TcgfkdixB0dkfC08RbcRoWtQ5Lb16SVXEm71I28f3Cq97QWFVud1/OX+M3eAfXOnw
		fzXk00PaSQzMRFdQ9b46O/xiTW3WDM3egMfo0hSkL7QjZDSj/B7bH",
		
		//异步通知地址
		'notify_url' => "http://外网可访问网关地址/alipay.trade.page.pay-PHP-UTF-8/notify_url.php",
		
		//同步跳转
		'return_url' => "http://外网可访问网关地址/alipay.trade.page.pay-PHP-UTF-8/return_url.php",

		//编码格式
		'charset' => "UTF-8",

		//签名方式
		'sign_type'=>"RSA2",

		//支付宝网关
		'gatewayUrl' => "https://openapi.alipaydev.com/gateway.do",



		//支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
		'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAwbL4RTdsz/1Mw08hAGdzeWYlG
		Aqf1MwsJSBPUkxWDaZj4m6wRE3A+LKB0cMXfHJPSSymX17kxmqOkKwK3UnfGvD7iD/tYgquFZjygpXaVRM/oYoGlfPgDA9CeKMmJ
		ttotmdD6zKIm52q7rYF7TpUALrHGoJ7fBRR3TLJ2KLKmG7+C/zdvjUBe7P73Z/+Kq5q/deOlBjVM5tfso2Y735Zbv2vqyRQHP8n
		2ucRfzfFUYRnMYD/K0EiLKeCAH6l6Ho0DbQE+nQSh6m+pUmYFuY+lqJDOsetU60xQN0zsX05Tl+RsAcfgtFtAf+vhP5G97PnXiioGQw0PUHEMcQk
		/YRTnwIDAQABsentinel",
);