<?php
namespace itph;

class ITPH_Markup_Builder {
	/**
	 * Produce a markup for the input field.
	 */
	public static function input_field( array $options ) : string {
		$defaults = [
			'type' => 'text',
			'class' => 'regular-text'
		];

		$options = array_merge(
			$defaults,
			$options
		);

		return "
			<input type=\"{$options['type']}\"
				class=\"{$options['class']}\"
				id=\"{$options['option']}\"
				name=\"itph_plugin_options[{$options['option']}]\"
				value=\"{$options['value']}\" />
		";
	}

	/**
	 * Produce a markup for the radio field.
	 */
	public static function radio( array $options ) : string {
		$checked = checked( $options['value'], $options['assigned_value'], false );

		return "
			<label>
				<input type=\"radio\"
					name=\"itph_plugin_options[{$options['option']}]\"
					value=\"{$options['assigned_value']}\"
					$checked />
				<span>{$options['label']}</span>
			</label>
		";
	}
}
?>
