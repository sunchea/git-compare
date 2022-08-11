<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);?>
<div class="social-icons">
	<ul>
		<?if(!empty($arParams["VK"])):?>
			<li class="vk"><a href="<?=$arParams["VK"]?>" target="_blank" title="<?=GetMessage("SOCIAL_VK")?>"><?=GetMessage("SOCIAL_VK")?></a></li>
		<?endif;?>
		<?if(!empty($arParams["FACEBOOK"])):?>
			<li class="facebook"><a href="<?=$arParams["FACEBOOK"]?>" target="_blank" title="<?=GetMessage("SOCIAL_FACEBOOK")?>"><?=GetMessage("SOCIAL_FACEBOOK")?></a></li>
		<?endif;?>
		<?if(!empty($arParams["TWITTER"])):?>
			<li class="twitter"><a href="<?=$arParams["TWITTER"]?>" target="_blank" title="<?=GetMessage("SOCIAL_TWITTER")?>"><?=GetMessage("SOCIAL_TWITTER")?></a></li>
		<?endif;?>
		<?if(!empty($arParams["ODNOKLASSNIKI"])):?>
			<li class="odnoklassniki"><a href="<?=$arParams["ODNOKLASSNIKI"]?>" target="_blank" title="<?=GetMessage("SOCIAL_ODNOKLASSNIKI")?>"><?=GetMessage("SOCIAL_ODNOKLASSNIKI")?></a></li>
		<?endif;?>
		<?if(!empty($arParams["MAILRU"])):?>
			<li class="mail"><a href="<?=$arParams["MAILRU"]?>" target="_blank" title="<?=GetMessage("SOCIAL_MAILRU")?>"><?=GetMessage("SOCIAL_MAILRU")?></a></li>
		<?endif;?>
		<?if(!empty($arParams["LIVEJOURNAL"])):?>
			<li class="lj"><a href="<?=$arParams["LIVEJOURNAL"]?>" target="_blank" title="<?=GetMessage("SOCIAL_LIVEJOURNAL")?>"><?=GetMessage("SOCIAL_LIVEJOURNAL")?></a></li>
		<?endif;?>
	</ul>
</div>