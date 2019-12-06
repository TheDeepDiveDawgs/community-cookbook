import React, {Component} from 'react';
import '../stylesheets/stylesheet.css';

class RecipeSubmission extends Component {
	static defaultProps = {
		onClose() {},
		onSave() {}
	}

	constructor(props) {
		super(props);
		this.state = {
			recipeName: '',
			steps: "",
			description: [''],
			img: ''
		};

		this.handleChange = this.handleChange.bind(this);
		this.handleNewDescription = this.handleNewDescription.bind(this);
		this.handleChangeIng = this.handleChangeIng.bind(this);
		this.handleSubmit = this.handleSubmit.bind(this);
	}

	handleChange(e) {
		this.setState({[e.target.name]: e.target.value});
	}

	handleNewDescription(e) {
		const {descriptions} = this.state;
		this.setState({descriptions: [...descriptions, '']});
	}

	handleChangeIng(e) {
		const index = Number(e.target.name.split('-')[1]);
		const descriptions = this.state.descriptions.map((ing, i) => (
			i === index ? e.target.value : ing
		));
		this.setState({descriptions});
	}

	handleSubmit(e) {
		e.preventDefault();
		this.props.onSave({...this.state});
		this.setState({
			title: '',
			steps: '',
			description: [''],
			img: ''
		})
	}

	render() {
		const {title, steps, img, description} = this.state;
		const {onClose} = this.props;
		let inputs = description.map((ing, i) => (
			<div
				className="recipe-form-line"
				key={`description-${i}`}
			>
				<label>{i+1}.
					<input
						type="text"
						name={`description-${i}`}
						value={ing}
						size={45}
						autoComplete="off"
						placeholder=" Description"
						onChange={this.handleChangeIng} />
				</label>
			</div>
		));

		return (
			<div className="recipe-form-container">
				<form className='recipe-form' onSubmit={this.handleSubmit}>
					<button
						type="button"
						className="close-button"
						onClick={onClose}
					>
						X
					</button>
					<div className='recipe-form-line'>
						<label htmlFor='recipe-title-input'>Title</label>
						<input
							id='recipe-name-input'
							key='title'
							name='title'
							type='text'
							value={title}
							size={42}
							autoComplete="off"
							onChange={this.handleChange}/>
					</div>
					<label
						htmlFor='recipe-description-input'
						style={{marginTop: '5px'}}
					>
						Instructions
					</label>
					<textarea
						key='description'
						id='recipe-description-input'
						type='Steps'
						name='description'
						rows='8'
						cols='50'
						autoComplete='off'
						value={description}
						onChange={this.handleChange}/>
					{inputs}
					<button
						type="button"
						onClick={this.handleNewDescription}
						className="buttons"
					>
						+
					</button>
					<div className='recipe-form-line'>
						<label htmlFor='recipe-img-input'>Image Url</label>
						<input
							id='recipe-img-input'
							type='text'
							placeholder=''
							name='img'
							value={img}
							size={36}
							autoComplete='off'
							onChange={this.handleChange} />
					</div>
					<button
						type="submit"
						className="buttons"
						style={{alignSelf: 'flex-end', marginRight: 0}}
					>
						SAVE
					</button>
				</form>
			</div>
		)
	}
}

export default RecipeSubmission;