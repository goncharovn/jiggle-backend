<?php

namespace jiggle\app\Controllers;

use jiggle\app\Core\Controller;
use jiggle\app\Models\UserModel;
use jiggle\app\Views\Components\AccountBodyComponent;
use jiggle\app\Views\Components\AccountComponent;
use jiggle\app\Views\Components\AccountMenuComponent;
use jiggle\app\Views\Components\DefaultLayoutComponent;

class AccountPagesController extends Controller
{
    private UserModel $user;
    private string $accountMenu;

    public function __construct()
    {
        parent::__construct();

        if (!AccessController::isUserLoggedIn()) {
            header('Location: /');
            exit();
        }

        $this->user = UserModel::getUserById($_SESSION['user_id']);
        $this->accountMenu = new AccountMenuComponent($this->user->getRole() === 'admin');
    }

    public function showOverviewPage(): void
    {
        if (empty($this->user->getName())) {
            $greetings = 'Hi!';
        } else {
            $greetings = "Hi, {$this->user->getName()}!";
        }

        $this->renderAccountPage(
            'overview',
            'My Account - Overview',
            $greetings
        );
    }

    public function showOrderHistoryPage(): void
    {
        $this->renderAccountPage(
            'order_history',
            'My Account - Order History',
            'Order History'
        );
    }

    public function showDeliveryAddressPage(): void
    {
        $this->renderAccountPage(
            'delivery_addresses',
            'My Account - Delivery Addresses',
            'Delivery Addresses'
        );
    }

    public function showMyDetailsPage(): void
    {
        $this->renderAccountPage(
            'my_details',
            'My Account - My Details',
            'My Details'
        );
    }

    private function renderAccountPage($templateName, $title, $accountHeading): void
    {
        $accountBody = new AccountBodyComponent($templateName, $this->user);

        $main = new AccountComponent(
            $this->accountMenu,
            $accountHeading,
            $accountBody
        );

        echo new DefaultLayoutComponent($title, $main);
    }
}