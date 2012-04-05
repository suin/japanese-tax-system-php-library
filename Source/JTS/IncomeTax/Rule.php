<?php

namespace JTS\IncomeTax;

use \InvalidArgumentException;

class Rule
{
	protected $max;
	protected $rate;
	protected $deduction;

	/**
	 * Set max.
	 * @param int $max
	 * @return $this
	 * @throws \InvalidArgumentException
	 */
	public function max($max)
	{
		if ( $max < 0 )
		{
			throw new InvalidArgumentException(sprintf('%s was given: max must be more than 0', $max));
		}

		$this->max = $max;
		return $this;
	}

	/**
	 * Set rate.
	 * @param int $rate
	 * @return $this
	 * @throws \InvalidArgumentException
	 */
	public function rate($rate)
	{
		if ( $rate < 0 or 100 < $rate )
		{
			throw new InvalidArgumentException(sprintf('%s was given: rate must be between 0 and 100', $rate));
		}

		$this->rate = $rate / 100;
		return $this;
	}

	/**
	 * Set deduction amount.
	 * @param int $deduction
	 * @return $this
	 * @throws \InvalidArgumentException
	 */
	public function deduction($deduction)
	{
		if ( $deduction < 0 )
		{
			throw new InvalidArgumentException(sprintf('%s was given: deduction must be more than 0', $deduction));
		}

		$this->deduction = $deduction;
		return $this;
	}

	/**
	 * Determine if this rule is available for a specific income amount.
	 * @param int $income
	 * @return bool
	 */
	public function isAvailable($income)
	{
		return ( $income <= $this->max );
	}

	/**
	 * Calculate income tax.
	 * @param int $income
	 * @return int
	 */
	public function getTax($income)
	{
		return intval(( $income * $this->rate ) - $this->deduction);
	}
}
