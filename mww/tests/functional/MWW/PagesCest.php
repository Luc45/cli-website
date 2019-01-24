<?php

class PagesCest
{
    /**
     * Calling index method on Page should output it's contents
     *
     * @param FunctionalTester $I
     * @throws \Codeception\Exception\ModuleException
     */
    public function it_should_render_page(FunctionalTester $I)
    {
        $page = <<<PHP
<?php
namespace App\Pages;
use MWW\Pages\Page;
class FunctionalTestPage extends Page {
    public function index() {
        echo 'I am a functional testing page!';
    }
}
PHP;

        $I->writeToMuPluginFile('mww/app/Pages/FunctionalTestPage.php', $page);

        $add_route = <<<PHP
add_filter('wp-routes/register_routes', function() {
    klein_respond('GET', '/test_it_should_render_page', function() {
        \$page = new App\Pages\FunctionalTestPage;
        \$page->index();
    });
});
PHP;

        $I->haveMuPlugin('a.php', $add_route);

        $I->amOnPage('test_it_should_render_page');
        $I->see('I am a functional testing page!');

        $I->deleteMuPluginFile('mww/app/Pages/FunctionalTestPage.php');
    }

    /**
     * Calling index method on Page which includes a template, should include the template
     *
     * @param FunctionalTester $I
     * @throws \Codeception\Exception\ModuleException
     */
    public function it_should_render_page_with_template(FunctionalTester $I)
    {
        $template = <<<EOF
I am a page with a template!
EOF;

        $I->writeToMuPluginFile('mww/views/functional-testing-page.php', $template);

        $page = <<<PHP
<?php
namespace App\Pages;
use MWW\Pages\Page;
class FunctionalTestPageWithTemplate extends Page {
    public function index() {
        \$this->template->include('functional-testing-page');
    }
}
PHP;

        $I->writeToMuPluginFile('mww/app/Pages/FunctionalTestPageWithTemplate.php', $page);

        $add_route = <<<PHP
add_filter('wp-routes/register_routes', function() {
    klein_respond('GET', '/it_should_render_page_with_template', function() {
        \$page = new App\Pages\FunctionalTestPageWithTemplate;
        \$page->index();
    });
});
PHP;
        $I->haveMuPlugin('a.php', $add_route);

        $I->amOnPage('/it_should_render_page_with_template');
        $I->see('I am a page with a template!');

        $I->deleteMuPluginFile('mww/app/Pages/FunctionalTestPageWithTemplate.php');
        $I->deleteMuPluginFile('mww/views/functional-testing-page.php');
    }

    /**
     * Calling index method on Page which includes a template, should include the template and pass parameters to the view
     *
     * @param FunctionalTester $I
     * @throws \Codeception\Exception\ModuleException
     */
    public function it_should_render_page_with_template_and_pass_parameters_to_view(FunctionalTester $I)
    {
        $template = <<<PHP
I am a page with a template with this data: <?php echo \$data ?>
PHP;

        $I->writeToMuPluginFile('mww/views/functional-testing-page-with-parameters.php', $template);

        $page = <<<PHP
<?php
namespace App\Pages;
use MWW\Pages\Page;
class FunctionalTestPageWithTemplateWithParameters extends Page {
    public function index() {
        \$this->template->include('functional-testing-page-with-parameters', ['data' => 'Working']);
    }
}
PHP;

        $I->writeToMuPluginFile('mww/app/Pages/FunctionalTestPageWithTemplateWithParameters.php', $page);

        $add_route = <<<PHP
add_filter('wp-routes/register_routes', function() {
    klein_respond('GET', '/it_should_render_page_with_template_with_parameters', function() {
        \$page = new App\Pages\FunctionalTestPageWithTemplateWithParameters;
        \$page->index();
    });
});
PHP;
        $I->haveMuPlugin('a.php', $add_route);

        $I->amOnPage('/it_should_render_page_with_template_with_parameters');
        $I->see('I am a page with a template with this data: Working');

        $I->deleteMuPluginFile('mww/app/Pages/FunctionalTestPageWithTemplateWithParameters.php');
        $I->deleteMuPluginFile('mww/views/functional-testing-page-with-parameters.php');
    }
}
