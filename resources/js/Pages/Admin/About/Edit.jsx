import AdminLayout from '@/Layouts/AdminLayout';
import { useForm } from '@inertiajs/react';
import { Save } from 'lucide-react';

export default function AboutEdit({ about }) {
    const { data, setData, put, processing, errors } = useForm({
        name:          about?.name || 'Nanang Aditya',
        job_title_en:  about?.job_title_en || 'Software Engineer',
        job_title_id:  about?.job_title_id || 'Software Engineer',
        bio_en:        about?.bio_en || '',
        bio_id:        about?.bio_id || '',
        location:      about?.location || 'Indonesia',
        email:         about?.email || 'nanangaditya2001@gmail.com',
        github_url:    about?.github_url || 'https://github.com/Nanang212',
        linkedin_url:  about?.linkedin_url || 'https://www.linkedin.com/in/nanang-aditya/',
    });

    const field = (name, label, type = 'text') => (
        <div>
            <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">{label}</label>
            <input
                type={type}
                className="input"
                value={data[name]}
                onChange={e => setData(name, e.target.value)}
            />
            {errors[name] && <p className="text-red-500 text-xs mt-1">{errors[name]}</p>}
        </div>
    );

    const textarea = (name, label, rows = 4) => (
        <div>
            <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">{label}</label>
            <textarea
                rows={rows}
                className="input resize-none"
                value={data[name]}
                onChange={e => setData(name, e.target.value)}
            />
            {errors[name] && <p className="text-red-500 text-xs mt-1">{errors[name]}</p>}
        </div>
    );

    const submit = (e) => {
        e.preventDefault();
        put('/admin/about');
    };

    return (
        <AdminLayout title="About Me">
            <div className="max-w-2xl space-y-6">
                <div className="card p-6 border-l-4 border-primary-600">
                    <p className="text-sm text-slate-600 dark:text-slate-400">
                        This content appears on the <strong>About</strong> and <strong>Home</strong> pages of your portfolio.
                    </p>
                </div>

                <form onSubmit={submit} className="space-y-6">
                    {/* Basic Info */}
                    <div className="card p-6 space-y-4">
                        <h3 className="font-semibold text-slate-800 dark:text-white">Basic Information</h3>
                        <div className="grid sm:grid-cols-2 gap-4">
                            {field('name', 'Full Name')}
                            {field('location', 'Location')}
                        </div>
                        <div className="grid sm:grid-cols-2 gap-4">
                            {field('job_title_en', 'Job Title (English)')}
                            {field('job_title_id', 'Job Title (Indonesian)')}
                        </div>
                        {field('email', 'Email', 'email')}
                    </div>

                    {/* Social links */}
                    <div className="card p-6 space-y-4">
                        <h3 className="font-semibold text-slate-800 dark:text-white">Social Links</h3>
                        {field('github_url', 'GitHub URL', 'url')}
                        {field('linkedin_url', 'LinkedIn URL', 'url')}
                    </div>

                    {/* Bio */}
                    <div className="card p-6 space-y-4">
                        <h3 className="font-semibold text-slate-800 dark:text-white">Bio</h3>
                        {textarea('bio_en', 'Bio (English)', 5)}
                        {textarea('bio_id', 'Bio (Indonesian)', 5)}
                    </div>

                    <button type="submit" disabled={processing} className="btn-primary w-full justify-center">
                        <Save size={16}/> Save About Me
                    </button>
                </form>
            </div>
        </AdminLayout>
    );
}
