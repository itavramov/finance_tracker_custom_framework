<script>
    var config = {
        url: {
                baseURL: 'https://ivan-avramov-finance-tracker.upnetix.tech/',
                index: '<?php echo \Router\Url::generateUrl("indexPage") ?>',
                userRegistration: '<?php echo \Router\Url::generateUrl("userRegistration") ?>',
                login: '<?php echo \Router\Url::generateUrl("userLogin") ?>',
                logout: '<?php echo \Router\Url::generateUrl("userLogout") ?>',
                userEdit: '<?php echo \Router\Url::generateUrl("userEdit") ?>',
                userExists: '<?php echo \Router\Url::generateUrl("userExists") ?>',
                userInfo: '<?php echo \Router\Url::generateUrl("userInfo") ?>',
                accountRegistration: '<?php echo \Router\Url::generateUrl("accountRegistration") ?>',
                allAccounts: '<?php echo \Router\Url::generateUrl("allAccounts") ?>',
                accountEdit: '<?php echo \Router\Url::generateUrl("accountEdit") ?>',
                accountDelete: '<?php echo \Router\Url::generateUrl("deleteAccount") ?>',
                accountInfo: '<?php echo \Router\Url::generateUrl("accountInfo") ?>',
                budgetRegistration: '<?php echo \Router\Url::generateUrl("budgetRegister") ?>',
                budgetListing: '<?php echo \Router\Url::generateUrl("budgetListing") ?>',
                budgetDelete: '<?php echo \Router\Url::generateUrl("budgetDelete") ?>',
                recordRegistration: '<?php echo \Router\Url::generateUrl("registerRecord") ?>',
                allRecords: '<?php echo \Router\Url::generateUrl("listRecords") ?>',
                recordsSum: '<?php echo \Router\Url::generateUrl("recordsTotalSum") ?>',
                recordExpenses: '<?php echo \Router\Url::generateUrl("recordExpenses") ?>',
                lastFiveRecords: '<?php echo \Router\Url::generateUrl("lastFiveRecords") ?>',
                incomeAndExpense: '<?php echo \Router\Url::generateUrl("listIncomeAndExpense") ?>',
                radarExpenses: '<?php echo \Router\Url::generateUrl("radarExpenses") ?>',
                averageIncome: '<?php echo \Router\Url::generateUrl("averageIncome") ?>',
                averageExpense: '<?php echo \Router\Url::generateUrl("averageExpense") ?>',
                categoryRegistration: '<?php echo \Router\Url::generateUrl("registerCategory") ?>',
                allCategories: '<?php echo \Router\Url::generateUrl("allCategories") ?>'
        }
    }
</script>
