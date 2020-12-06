<?php
if (!isConnect('admin')) {
    throw new Exception('{{401 - Accès non autorisé}}');
}
sendVarToJS('eqType', 'github');
$eqLogics = eqLogic::byType('github');

$has = ["account"=>false,"repo"=>false];

foreach ($eqLogics as $eqLogic) {
    if ($eqLogic->getConfiguration('type') == '') {
        $eqLogic->setConfiguration('type', 'account');
        $eqLogic->save();
    }
    $type=$eqLogic->getConfiguration('type','');
    if($type) {
        $has[$type]=true;
    }
}
?>

<div class="row row-overflow">
    <div class="col-xs-12 eqLogicThumbnailDisplay">
      <legend><i class="fas fa-cog"></i>  {{Gestion}}</legend>
       <div class="eqLogicThumbnailContainer">
            <div class="cursor eqLogicAction logoPrimary" data-action="add"  >
                <i class="fas fa-plus-circle"></i>
                <br>
                <span >{{Ajouter}}</span>
            </div>
            <div class="cursor eqLogicAction logoSecondary" data-action="gotoPluginConf" >
                <i class="fas fa-wrench"></i>
                <br>
                <span>{{Configuration}}</span>
      </div>
    </div>
        <legend><i class="fas fa-table"></i>{{Mes Comptes Github}}
        </legend>
        <div class="panel">
            <div class="panel-body">
                <div class="eqLogicThumbnailContainer ">
            <?php
                    if($has['account']) {
                        foreach ($eqLogics as $eqLogic) {
                            if($eqLogic->getConfiguration('type','') != 'account') {
                                continue;
                            }
                            $opacity = ($eqLogic->getIsEnable()) ? '' : 'disableCard';
                            echo '<div class="eqLogicDisplayCard cursor '.$opacity.'" data-eqLogic_id="' . $eqLogic->getId() . '">';
                            echo '<img src="' . $eqLogic->getImage() . '"/>';
                            echo '<br>';
                            echo '<span class="name">' . $eqLogic->getHumanName(true, true) . '</span>';
                            echo '</div>';
                        }
            } else {
                        echo "<br/><br/><br/><center><span style='color:#767676;font-size:1.2em;font-weight: bold;'>{{Vous n'avez pas encore de compte Github, cliquez sur Ajouter un équipement pour commencer}}</span></center>";
                    }
                    ?>

                </div>
            </div>
        </div>
        <legend><i class="fas fa-table"></i> {{Mes Repositories}} <span class="cursor eqLogicAction" style="color:#fcc127" data-action="discover" data-action2="repos" title="{{Scanner les repositories}}"><i class="fas fa-bullseye"></i></span></legend>
        <div class="input-group" style="margin-bottom:5px;">
            <input class="form-control roundedLeft" placeholder="{{Rechercher}}" id="in_searchEqlogic2" />
            <div class="input-group-btn">
                <a id="bt_resetEqlogicSearch2" class="btn roundedRight" style="width:30px"><i class="fas fa-times"></i></a>
            </div>
        </div>
        <div class="panel">
            <div class="panel-body">
                <div class="eqLogicThumbnailContainer  second">
                    <?php
                    if($has['repo']) {
                foreach ($eqLogics as $eqLogic) {
                            if($eqLogic->getConfiguration('type','') != 'repo') {
                                continue;
                            }
                            $opacity = '';
                            if ($eqLogic->getIsEnable() != 1) {
                                $opacity = ' disableCard';
                            }

                            echo '<div class="eqLogicDisplayCard cursor  second '.$opacity.'" data-eqLogic_id="' . $eqLogic->getId() . '">';
                            echo '<img src="' . $eqLogic->getImage() . '"/>';
                            echo '<br>';
                            echo '<span class="name">' . $eqLogic->getHumanName(true, true) . '</span>';
                    echo '</div>';
                }
                    } else {
                        echo "<br/><br/><br/><center><span style='color:#767676;font-size:1.2em;font-weight: bold;'>{{Scannez les repositories pour les créer}}</span></center>";
            }
            ?>

                </div>
            </div>
        </div>
    </div>
</div>
    <div class="col-lg-10 col-md-9 col-sm-8 eqLogic" style="border-left: solid 1px #EEE; padding-left: 25px;display: none;">
    <br />
  <a class="btn btn-success eqLogicAction pull-right" data-action="save"><i class="fas fa-check-circle"></i> {{Sauvegarder}}</a>
  <a class="btn btn-danger eqLogicAction pull-right" data-action="remove"><i class="fas fa-minus-circle"></i> {{Supprimer}}</a>
  <a class="btn btn-default eqLogicAction pull-right" data-action="configure"><i class="fas fa-cogs"></i> {{Configuration avancée}}</a>
  <ul class="nav nav-tabs" role="tablist">
   <li role="presentation"><a href="" class="eqLogicAction" aria-controls="home" role="tab" data-toggle="tab" data-action="returnToThumbnailDisplay"><i class="fas fa-arrow-circle-left"></i></a></li>
   <li role="presentation" class="active"><a href="#eqlogictabin" aria-controls="home" role="tab" data-toggle="tab"><i class="fas fa-tachometer-alt"></i> {{Equipement}}</a></li>
   <li role="presentation"><a href="#cmdtab" aria-controls="profile" role="tab" data-toggle="tab"><i class="fas fa-list-alt"></i> {{Commandes}}</a></li>
 </ul>
 <div class="tab-content" style="height:calc(100% - 50px);overflow:auto;overflow-x: hidden;">
  <div role="tabpanel" class="tab-pane active" id="eqlogictabin">
    <br/>
        <div class="row">
        <div class="col-sm-6">
        <form class="form-horizontal">
            <fieldset>
                <legend>
                    {{Général}}
               </legend>
                <div class="form-group">
                    <label class="col-lg-2 control-label">{{Nom de l'équipement}}</label>
                    <div class="col-lg-3">
                        <input type="text" class="eqLogicAttr form-control" data-l1key="id" style="display : none;" />
                        <input type="text" class="eqLogicAttr form-control" data-l1key="name" placeholder="{{Nom du compte Gihub}}"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-2 control-label" >{{Objet parent}}</label>
                    <div class="col-lg-3">
                        <select class="form-control eqLogicAttr" data-l1key="object_id">
                            <option value="">{{Aucun}}</option>
                            <?php
                            foreach (jeeObject::all() as $object) {
                                echo '<option value="' . $object->getId() . '">' . $object->getName() . '</option>'."\n";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-2 control-label">{{Catégorie}}</label>
                    <div class="col-lg-8">
                        <?php
                        foreach (jeedom::getConfiguration('eqLogic:category') as $key => $value) {
                            echo '<label class="checkbox-inline">'."\n";
                            echo '<input type="checkbox" class="eqLogicAttr" data-l1key="category" data-l2key="' . $key . '" />' . $value['name'];
                            echo '</label>'."\n";
                        }
                        ?>

                    </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label" ></label>
                    <div class="col-sm-10">
                    <label class="checkbox-inline"><input type="checkbox" class="eqLogicAttr" data-label-text="{{Activer}}" data-l1key="isEnable" checked/>Activer</label>
                    <label class="checkbox-inline"><input type="checkbox" class="eqLogicAttr" data-label-text="{{Visible}}" data-l1key="isVisible" checked/>Visible</label>
                    </div>

                </div>
                <div class="form-group" id="div_loginGithub" style="display: none;">
                    <label class="col-lg-2 control-label">{{Login Github}}</label>
                    <div class="col-lg-3">
                        <input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="login"/>
                    </div>
                </div>
                <div class="form-group" id="div_tokenGithub" style="display: none;">
                    <label class="col-lg-2 control-label">{{Token Github}}</label>
                    <div class="col-lg-3">
                        <input type="password" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="token"/>
                    </div>
                </div>
            </fieldset>
        </form>
        </div>
  </div>
  </div>
 </div></div>

<?php include_file('desktop', 'github', 'js', 'github'); ?>
<?php include_file('core', 'plugin.template', 'js'); ?>