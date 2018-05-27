<?php
namespace itph;

require_once 'class-itph-markup-builder.php';

class ITPH_Markup_Displayer {
	/**
	 * Constructor.
	 */
	public function __construct( array $args ) {
		$this->options = $args['options'];
	}

	/**
	 * Display simple input field.
	 */
	public function display_field_markup( array $args ) : void {
		$args['value'] = $this->options[ $args['option'] ];
		echo ITPH_Markup_Builder::input_field( $args );
	}

	/**
	 * Display choices for the answers.
	 */
	public function display_answers_markup() : void {
		echo ITPH_Markup_Builder::radio( [
			'option' => 'answer_set_type',
			'value' => $this->options['answer_set_type'],
			'assigned_value' => 'standard',
			'label' => 'Use standard set of answers'
		] );
		?>
		<br /><br />
		<p>
			<?php
			echo ITPH_Markup_Builder::input_field( [
				'option' => 'positive_answer',
				'value' => $this->options['positive_answer']
			] );
			echo ITPH_Markup_Builder::input_field( [
				'type' => 'color',
				'class' => 'small-text',
				'option' => 'positive_answer_fg_color',
				'value' => $this->options['positive_answer_fg_color']
			] );
			echo ITPH_Markup_Builder::input_field( [
				'type' => 'color',
				'class' => 'small-text',
				'option' => 'positive_answer_bg_color',
				'value' => $this->options['positive_answer_bg_color']
			] );
			?>
			BUTTON PREVIEW: <span class="preview-button" id="positive_answer_button_preview"></span>
			<p class="description">(Text and colors for the positive answer button.)</p>
		</p><p>
			<?php
			echo ITPH_Markup_Builder::input_field( [
				'option' => 'negative_answer',
				'value' => $this->options['negative_answer']
			] );
			echo ITPH_Markup_Builder::input_field( [
				'type' => 'color',
				'class' => 'small-text',
				'option' => 'negative_answer_fg_color',
				'value' => $this->options['negative_answer_fg_color']
			] );
			echo ITPH_Markup_Builder::input_field( [
				'type' => 'color',
				'class' => 'small-text',
				'option' => 'negative_answer_bg_color',
				'value' => $this->options['negative_answer_bg_color']
			] );
			?>
			BUTTON PREVIEW: <span class="preview-button" id="negative_answer_button_preview"></span>
			<p class="description">(Text and colors for the negative answer button.)</p>
		</p>
		<br /><br />
		<?php
		echo ITPH_Markup_Builder::radio( [
			'option' => 'answer_set_type',
			'value' => $this->options['answer_set_type'],
			'assigned_value' => 'custom',
			'label' => 'Use custom set of answers'
		] );
		?>
		<br /><br />
		<p>
			<input type="hidden" id="custom-answer-set" value='<?php echo $this->options["custom_answer_set"]; ?>' name="itph_plugin_options[custom_answer_set]" />
			<input type="text" id="custom_answer" class="regular-text" />
			<input type="color" id="custom_answer_fg_color" class="small-text" value="#ffffff" />
			<input type="color" id="custom_answer_bg_color" class="small-text" value="#8080ff" />
			BUTTON PREVIEW: <span class="preview-button" id="custom_answer_button_preview"></span>
			<input type="button" id="add-custom-answer-item" class="button-secondary" value="Add" />
			<div id="custom-answer-set-layer"></div>
		</p>
		<br /><br />
		<?php
		echo ITPH_Markup_Builder::radio( [
			'option' => 'answer_set_type',
			'value' => $this->options['answer_set_type'],
			'assigned_value' => 'stars',
			'label' => 'Use star-based rating (&#9733;&#9733;&#9733;&#9733;&#9733;)'
		] );
		?>
		<br /><br />
		<?php
	}
	
	/**
	 * Display choices for the layout variant.
	 */
	public function display_layout_variants() : void {
		?>
		<div class="layout-previews">
		<label>
			<input type="radio"
				name="itph_plugin_options[layout]"
				value="inline-left" <?php checked( $this->options['layout'], 'inline-left' ); ?> />
			<div class="layout-preview layout-inline-left">
			</div>
		</label>
		<label>
			<input type="radio"
				name="itph_plugin_options[layout]"
				value="inline-right" <?php checked( $this->options['layout'], 'inline-right' ); ?> />
			<div class="layout-preview layout-inline-right">
			</div>
		</label>
		<label>
			<input type="radio"
				name="itph_plugin_options[layout]"
				value="inline-center" <?php checked( $this->options['layout'], 'inline-center' ); ?> />
			<div class="layout-preview layout-inline-center">
			</div>
		</label>
		<label>
			<input type="radio"
				name="itph_plugin_options[layout]"
				value="inline-justified" <?php checked( $this->options['layout'], 'inline-justified' ); ?> />
			<div class="layout-preview layout-inline-justified">
			</div>
		</label>
		</div>
		<div class="layout-previews">
		<label>
			<input type="radio"
				name="itph_plugin_options[layout]"
				value="multiline-left" <?php checked( $this->options['layout'], 'multiline-left' ); ?> />
			<div class="layout-preview layout-multiline-left">
			</div>
		</label>
		<label>
			<input type="radio"
				name="itph_plugin_options[layout]"
				value="multiline-right" <?php checked( $this->options['layout'], 'multiline-right' ); ?> />
			<div class="layout-preview layout-multiline-right">
			</div>
		</label>
		<label>
			<input type="radio"
				name="itph_plugin_options[layout]"
				value="multiline-center" <?php checked( $this->options['layout'], 'multiline-center' ); ?> />
			<div class="layout-preview layout-multiline-center">
			</div>
		</label>
		<label>
			<input type="radio"
				name="itph_plugin_options[layout]"
				value="multiline-justified" <?php checked( $this->options['layout'], 'multiline-justified' ); ?> />
			<div class="layout-preview layout-multiline-justified">
			</div>
		</label>
		</div>
		<?php
	}

	/**
	 * Display the feedback box styling fields.
	 */
	public function display_layout_styling() : void {
		?>
		<div id="margin-line-box">
			<div id="content-line-box">
				<div id="padding-line-box">
					<?php
					$box_model_props = [
						'margin-top', 'margin-bottom', 'margin-left', 'margin-right',
						'padding-top', 'padding-bottom', 'padding-left', 'padding-right'
					];
					foreach ( $box_model_props as $prop ) {
						echo ITPH_Markup_Builder::input_field( [
							'type' => 'number',
							'class' => 'box-model-prop',
							'option' => 'box-' . $prop,
							'value' => $this->options[ 'box-' . $prop ]
						] );
					}
					?>
					<span id="margin-line-caption">MARGIN</span>
					<span id="padding-line-caption">PADDING</span>
					<span id="text-content">Is this post helpful?</span>
				</div>
			</div>
		</div>
		<?php
		echo 'Text color: ';
		echo ITPH_Markup_Builder::input_field( [
			'type' => 'color',
			'class' => 'small-text box-styling',
			'option' => 'question_text_fg_color',
			'value' => $this->options['question_text_fg_color']
		] );
		echo 'Background color: ';
		echo ITPH_Markup_Builder::input_field( [
			'type' => 'color',
			'class' => 'small-text box-styling',
			'option' => 'question_text_bg_color',
			'value' => $this->options['question_text_bg_color']
		] );
		echo 'Border color: ';
		echo ITPH_Markup_Builder::input_field( [
			'type' => 'color',
			'class' => 'small-text box-styling',
			'option' => 'question_text_border_color',
			'value' => $this->options['question_text_border_color']
		] );
		?>
		<?php
	}
	
	/**
	 * Display choices for the post types engaged.
	 */
	public function display_post_types() : void {
		$post_types = get_post_types( [
			'public' => true
		] );
		foreach ( $post_types as $post_type ):
			?>
			<label class="post_type_involved">
				<input type="checkbox"
					name="itph_plugin_options[post_types][]"
					value="<?php echo $post_type; ?>"
					<?php checked( in_array( $post_type, $this->options['post_types'] ) ); ?> />
				<span><?php echo $post_type; ?></span>
			</label>
			<?php
		endforeach;
	}
}
?>
