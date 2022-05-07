<?php

/**
 * Forms actions.
 *
 * Dynamic Form Generator Components for application forms
 *
 * @package    frontend
 * @subpackage forms
 * @author     Webmasters Africa / Thomas Juma (thomas.juma@webmastersafrica.com)
 */
class formsActions extends sfActions
{
    /**
     * Executes 'Groups' action
     *
     * Displays form categories
     *
     * @param sfRequest $request A request object
     */
    public function executeGroups(sfWebRequest $request)
    {
        $q            = Doctrine_Query::create()
                                      ->from('FormGroups a')
                                      ->orderBy('a.group_name ASC')
        ;
        $this->groups = $q->execute();

        if ($request->getParameter("profile")) {
            //If profile is not active then redirect to profile
            $profile = Functions::get_client_profile($request->getParameter("profile"));

            if ($profile->getDeleted() == 0) {
                $this->getUser()->setAttribute("current_profile", $request->getParameter("profile"));
                $this->setLayout("layoutprofile");
            } else {
                $this->redirect("/index.php/profile/view/id/" . $profile->getId());
            }
        } else {
            $this->getUser()->setAttribute("current_profile", false);
            $this->setLayout("layoutdash");
        }
    }

    /**
     * Executes 'Info' action
     *
     * Displays a dynamically generated application form
     *
     * @param sfRequest $request A request object
     */
    public function executeInfo(sfWebRequest $request)
    {
        $q          = Doctrine_Query::create()
                                    ->from('ApForms a')
                                    ->where('a.form_id = ?', $request->getParameter("id"))
        ;
        $this->form = $q->fetchOne();

        if ($this->getUser()->getAttribute("current_profile")) {
            $this->setLayout("layoutprofile");
        } else {
            $this->setLayout("layoutdash");
        }
    }

    /**
     * Executes 'View' action
     *
     * Displays a dynamically generated application form
     *
     * @param sfRequest $request A request object
     */
    public function executeView(sfWebRequest $request)
    {
        if ($this->getUser()->getAttribute("current_profile")) {
            $this->setLayout("layoutprofile");
        } else {
            $this->setLayout("layoutformbuilder");
        }
    }

    /**
     * Executes 'Confirm' action
     *
     * Displays a dynamically generated application form
     *
     * @param sfRequest $request A request object
     */
    public function executeConfirm(sfWebRequest $request)
    {
        if ($this->getUser()->getAttribute("current_profile")) {
            $this->setLayout("layoutprofile");
        } else {
            $this->setLayout("layoutformbuilder");
        }
    }

    /**
     * Executes 'Payment' action
     *
     * Displays a dynamically generated application form
     *
     * @param sfRequest $request A request object
     */
    public function executePayment(sfWebRequest $request)
    {
        if ($this->getUser()->getAttribute("current_profile")) {
            $this->setLayout("layoutprofile");
        } else {
            $this->setLayout("layoutdash");
        }

        if ($request->getParameter("invoice")) {
            $_GET['invoice'] = $request->getParameter("invoice");
        }
    }


    /**
     * Executes 'Paymentbraintree' action
     *
     * Displays a dynamically generated application form
     *
     * @param sfRequest $request A request object
     */
    public function executePaymentbraintree(sfWebRequest $request)
    {
        $this->setLayout(false);
    }

    public function executeDownload(sfWebRequest $request)
    {
        $this->setLayout(false);
    }

    public function executeUpload(sfWebRequest $request)
    {
        $this->setLayout(false);
    }

    public function executeViewimg(sfWebRequest $request)
    {
        $this->setLayout(false);
    }

    /**
     * Executes 'Filterdropdown' action
     *
     * Filter a dropdown based on selected option
     *
     * @param sfRequest $request A request object
     */
    public function executeFilterdropdown(sfWebRequest $request)
    {
        $form_id    = $request->getParameter("form_id");
        $element_id = $request->getParameter("element_id");
        $link_id    = $request->getParameter("link_id");
        $option_id  = $request->getParameter("option_id");

        $q       = Doctrine_Query::create()
                                 ->from("ApDropdownFilters a")
                                 ->where("a.form_id = ? AND a.element_id = ? AND a.link_id = ? AND a.option_id = ?", array(
                                     $form_id,
                                     $element_id,
                                     $link_id,
                                     $option_id
                                 ))
        ;
        $filters = $q->execute();

        $filter_options = array();

        foreach ($filters as $filter) {
            $filter_options[] = "a.option_id = " . $filter->getLioptionId();
        }

        $filter_options_query = implode(" OR ", $filter_options);

        $q       = Doctrine_Query::create()
                                 ->from("ApElementOptions a")
                                 ->where("a.form_id = ?", $form_id)
                                 ->andWhere("a.element_id = ?", $link_id)
                                 ->andWhere($filter_options_query)
                                 ->orderBy("a.position ASC")
        ;
        $options = $q->execute();

        $filter_js = "";

        $q = Doctrine_Query::create()
                           ->from("ApDropdownFilters a")
                           ->where("a.form_id = ? AND a.element_id = ?", array($form_id, $link_id))
        ;

        if ($q->count() > 0) {
            $filter = $q->fetchOne();

            $filter_js = "onChange='filter_dropdown(" . $form_id . ", " . $link_id . ", " . $filter->getLinkId() . ", this.value);'";
        }

        echo "<select class='element select' id='element_" . $link_id . "' name='element_" . $link_id . "' " . $filter_js . ">";
        echo "<option></option>";
        foreach ($options as $option) {
            echo "<option value='" . $option->getOptionId() . "'>" . $option->getOptionText() . "</option>";
        }
        echo "</select>";
        exit;
    }

    /**
     * Executes 'Parcelleowner' action
     *
     * Filter a dropdown based on selected option
     *
     *@param sfRequest $request A request object
     *@author jules@mediabox.bi
     */
    public function executeParcelleowner(sfWebRequest $request)
    {
        $requerant_id    = $request->getParameter("requerant_id");
        $statement="SELECT `ID_PARCELLE`, `ID_REQUERANT`, `NUMERO_PARCELLE` FROM `parcelle_attribution` WHERE `ID_REQUERANT`=".$requerant_id;
        $parcelle_attribution = Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAssoc($statement);



        
        echo "<option></option>";
        foreach ($parcelle_attribution as $option) {
            echo "<option value='" . $option["ID_PARCELLE"] . "'>" . $option["NUMERO_PARCELLE"] . "</option>";
        }
         exit;
    }    

    public function executeDelete(sfWebRequest $request)
    {
        $this->setLayout(false);
    }

    /**
     * Executes 'Confirmpayment' action
     *
     * Payment form
     *
     * @param sfRequest $request A request object
     */
    public function executeConfirmpayment(sfWebRequest $request)
    {
        if (empty($this->getUser()->getAttribute("invoice_id"))) {
            $this->getUser()->setAttribute("invoice_id", $request->getParameter("invoiceid"));
        }

        $this->setLayout("layoutdashfull");
    }

    /**
     * Executes 'PaymentEco' action
     *
     * Displays a static form for payment with Ecocash
     *
     * @param sfRequest $request A request object
     */
    public function executePaymenteco(sfWebRequest $request)
    {
        if ($this->getUser()->getAttribute("current_profile")) {
            $this->setLayout("layoutprofile");
        } else {
            $this->setLayout("layoutdash");
        }

        if ($request->getParameter("invoice")) {
            $_GET['invoice'] = $request->getParameter("invoice");
        }

        if ($request->getPostParameter('Annuler')){
            if ($request->getParameter("invoice")) {
                $_GET['invoice'] = $request->getParameter("invoice");
                $this->redirect("/index.php/invoices/view/id/".$_GET['invoice']);
            } else{
                $this->redirect("/index.php/invoices/index");
            }
            return;
        }

        $this->numero = "";

        if ($request->getGetParameter('numero')) {
            $this->numero = $request->getParameter("numero");
        } elseif ($request->getPostParameter('numero')){
            $this->numero = $request->getPostParameter("numero");
        }

        $this->numero = trim($this->numero);

        $q = Doctrine_Query::create()
                           ->from('MfInvoice a')
                           ->where('a.id = ?', $request->getParameter("invoice"))
        ;
        $invoice  = $q->fetchOne();
        $this->invoice = $invoice;
    }

}
