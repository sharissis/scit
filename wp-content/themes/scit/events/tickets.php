<?php global $woocommerce; ?>
<?php
//	Alter the Action to not pull the Cart, but rather the page that has been loaded so it reloads.
//	FUTURE:	AJAX the Quantity so the page doesn't reoload at all by passing QUANTITY via HREF somehow...
?>
<?php
$Path=$_SERVER['REQUEST_URI'];
$URI='http://scit.com'.$Path;
//<form action="<?php echo esc_url( add_query_arg( 'wootickets_process', 1, $woocommerce->cart->get_cart_url() ) ); 5>"
?>
<form action="<?php echo esc_url( add_query_arg( 'wootickets_process', 1, $URI ) ); ?>"
      class="cart" method="post"
      enctype='multipart/form-data'>
		<table width="100%" class="tribe-events-tickets">
			<?php

			$is_there_any_product         = false;
			$is_there_any_product_to_sell = false;

			$gmt_offset = ( get_option( 'gmt_offset' ) >= '0' ) ? ' +' . get_option( 'gmt_offset' ) : " " . get_option( 'gmt_offset' );
			$gmt_offset = str_replace( array( '.25', '.5', '.75' ), array( ':15', ':30', ':45' ), $gmt_offset );

			ob_start();
			foreach ( $tickets as $ticket ) {

				global $product;
				$product = new WC_Product( $ticket->ID );


				if ( empty( $ticket->end_date ) ) {
					$ticket->end_date = apply_filters( 'wootickets_default_end_date', tribe_get_end_date(), $ticket->ID );
				}

				if ( ( !$product->is_in_stock() ) || ( empty( $ticket->start_date ) || time() > strtotime( $ticket->start_date . $gmt_offset ) ) && ( time() < strtotime( $ticket->end_date . $gmt_offset ) ) ) {

					$is_there_any_product = true;

					echo sprintf( "<input type='hidden' name='product_id[]' value='%d'>", $ticket->ID );

					echo "<tr>";
					echo "<td width='75'>";


					if ( $product->is_in_stock() ) {

						woocommerce_quantity_input( array( 'input_name'  => 'quantity_' . $ticket->ID,
						                                   'input_value' => 0,
						                                   'min_value'   => 0,
						                                   'max_value'   => $product->backorders_allowed() ? '' : $product->get_stock_quantity(), ) );

						$is_there_any_product_to_sell = true;

					} else {
						echo "<span class='tickets_nostock'>" . esc_html__( 'Out of stock!', 'tribe-wootickets' ) . "</span>";
					}
					echo "</td>";

					echo "<td nowrap='nowrap' class='tickets_name'>";
					echo $ticket->name;
					echo "</td>";

					echo "<td class='tickets_price'>";
					echo $product->get_price_html();
					echo "</td>";

					echo "<td class='tickets_description'>";
					echo $ticket->description;
					echo "</td>";

					echo "</tr>";
				}

			}
			$contents = ob_get_clean();
			if ( $is_there_any_product ) {
				
				//<h2 class="tribe-events-tickets-title"><?php _e( 'Tickets', 'tribe-wootickets' );5></h2>
				?>
				<?php echo $contents; ?>
				<?php
				if ( $is_there_any_product_to_sell ) { ?>
					<tr>
						<td colspan="4">

							<button type="submit"
							        class="button alt"><?php esc_html_e( 'Add to cart', 'tribe-wootickets' );?></button>
							<?php
							//	<br/><br/>
							//	Quick Add (1)
							//	<br/><br/>
							//	<a href="<?php echo $URI;5>?add-to-cart=<?php echo $ticket->ID; 5>" rel="nofollow" data-product_id="<?php echo $ticket->ID; 5>" class="add_to_cart_button button product_type_simple">Add Ticket to Cart</a>
							?>

						</td>
					</tr>
					<?php
				}
			}
			else
			{
				echo '<tr><td colspan="4"><br/><h2>This is a FREE Show!</h2><h4><em>No ticket or reservation required.</em></h4></td></tr>';
			}
			?>

		</table>

</form>