<?php

namespace Drupal\share_location\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class SettingsForm.
 */
class SettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'share_location.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'settings_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('share_location.settings');
    $form['share_location'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Share Location'),
      '#description' => $this->t('Activate to activelly share your location'),
      '#default_value' => $config->get('share_location'),
    ];
    $form['seconds'] = [
      '#type' => 'number',
      '#title' => $this->t('Seconds to refresh location'),
      '#description' => $this->t('Seconds elapsed before refresh the location'),
      '#default_value' => $config->get('seconds'),
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $this->config('share_location.settings')
      ->set('share_location', $form_state->getValue('share_location'))
      ->set('seconds', $form_state->getValue('seconds'))
      ->save();
  }

}
