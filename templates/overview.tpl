{if $rawstatus eq 'active'}
<div class="row m-b-15">
	<div class="col-md-6 col-sm-12">
		<h4>服务信息 <small>Service Detail</small></h4>
	</div>
</div>
<div id="minecraft-service">	
	<div class="row">
        <div class="col-md-4 col-sm-12">
			<div class="box">
				<div class="boxTitle">产品名称</div>
				<div>
					<span class="boxContent">{$product}</span>
				</div>
			</div>
        </div>
        <div class="col-md-4 col-sm-12">
			<div class="box">
				<div class="boxTitle">产品状态</div>
				<div>
					<span class="boxContent">{$status}</span>
				</div>
			</div>
        </div>
        <div class="col-md-4 col-sm-12">
			<div class="box">
				<div class="boxTitle">到期时间</div>
				<div>
					<span class="boxContent">{$nextduedate}</span>
				</div>
			</div>
        </div>
		<div class="col-md-12 col-sm-12"><br></div>
		<div class="col-md-4 col-sm-12">
            <div class="box">
                <div class="boxTitle">游戏名字</div>
                <div>
					<span class="boxContent">{$playerName}</span>
                </div>
            </div>
        </div>
		<div class="col-md-8 col-sm-12">
			 <div class="box">
                <div class="boxTitle">注意事项</div>
                <div>
					<span class="boxContent">部分商品需要使用购买时填写的游戏名登录游戏后才能兑换，如果您在购买时填写了错误的游戏名字，请立即与客服取得联系。</span>
                </div>
            </div>
		</div>
    </div>
</div>
{else}
	<p>抱歉,该产品目前无法管理 ({$status})</p>
	{if $suspendreason}
		<p>原因：{$suspendreason}</p>
	{/if}
{/if}