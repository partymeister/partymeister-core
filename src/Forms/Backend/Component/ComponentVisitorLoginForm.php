<?php

namespace Partymeister\Core\Forms\Backend\Component;

use Kris\LaravelFormBuilder\Form;
use Motor\CMS\Models\Navigation;

/**
 * Class ComponentVisitorLoginForm
 *
 * @package Partymeister\Core\Forms\Backend\Component
 */
class ComponentVisitorLoginForm extends Form
{
    /**
     * @return mixed|void
     */
    public function buildForm()
    {
        $nodes = Navigation::where('scope', 'main')
                           ->where('parent_id', '!=', null)
                           ->defaultOrder()
                           ->get();

        $navigationItemOptions = [];

        foreach ($nodes as $node) {
            $prefixes = [];
            foreach ($node->ancestors as $ancestor) {
                $prefixes[] = $ancestor->name;
            }
            $navigationItemOptions[$node->id] = implode(' > ', $prefixes).' > '.$node->name;
        }

        $this->add('visitor_registration_page_id', 'select', [
            'label'       => trans('partymeister-core::component/visitor-logins.visitor_registration_page'),
            'empty_value' => trans('motor-backend::backend/global.please_choose'),
            'choices'     => $navigationItemOptions,
        ]);

        $this->add('entries_page_id', 'select', [
            'label'       => trans('partymeister-core::component/visitor-logins.entries_page'),
            'empty_value' => trans('motor-backend::backend/global.please_choose'),
            'choices'     => $navigationItemOptions,
        ]);

        $this->add('voting_page_id', 'select', [
            'label'       => trans('partymeister-core::component/visitor-logins.voting_page'),
            'empty_value' => trans('motor-backend::backend/global.please_choose'),
            'choices'     => $navigationItemOptions,
        ]);

        $this->add('comments_page_id', 'select', [
            'label'       => trans('partymeister-core::component/visitor-logins.comments_page'),
            'empty_value' => trans('motor-backend::backend/global.please_choose'),
            'choices'     => $navigationItemOptions,
        ]);
    }
}
