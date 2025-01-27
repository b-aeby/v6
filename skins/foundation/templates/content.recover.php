{*
 * CubeCart v6
 * ========================================
 * CubeCart is a registered trade mark of CubeCart Limited
 * Copyright CubeCart Limited 2023. All rights reserved.
 * UK Private Limited Company No. 5323904
 * ========================================
 * Web:   https://www.cubecart.com
 * Email:  hello@cubecart.com
 * License:  GPL-3.0 https://www.gnu.org/licenses/quick-guide-gplv3.html
 *}
<form action="{$VAL_SELF}" method="post" id="recover_password">
  <h2>{$LANG.account.recover_password}</h2>
  <p>{$LANG.account.recover_password_text}</p>
  <label for="email">{$LANG.common.email}</label>
  <input type="text" name="email" id="email" class="required" placeholder="{$LANG.common.email} {$LANG.form.required}">
  {include file='templates/content.recaptcha.php' ga_fid='recover'}
  <div><input type="submit" value="{$LANG.form.submit}" id="recover_submit" data-form-id="recover_password" class="g-recaptcha button"></div>
</form>
<div class="hide" id="validate_email">{$LANG.common.error_email_invalid}</div>