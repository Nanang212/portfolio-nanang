import AdminLayout from '@/Layouts/AdminLayout';
import { Link, router, usePage } from '@inertiajs/react';
import { ArrowLeft, Save, Upload, X, ExternalLink, Link as LinkIcon, Image as ImageIcon, CheckCircle } from 'lucide-react';
import { useRef, useState } from 'react';

export default function ProjectForm({ project }) {
    const isEditing = !!project;
    const fileRef = useRef(null);
    const { props } = usePage();
    const pageErrors = props.errors || {};
    const flash = props.flash || {};

    const [processing, setProcessing] = useState(false);
    const [successMsg, setSuccessMsg] = useState(flash.success || null);
    const [formErrors, setFormErrors] = useState({});

    // Build initial previews from existing image_paths
    const buildInitialPreviews = () => {
        const paths = project?.image_paths ?? [];
        return paths.map(p => ({ src: `/storage/${p}`, path: p, isExisting: true }));
    };

    const [previews, setPreviews] = useState(buildInitialPreviews);
    const [newFiles, setNewFiles] = useState([]);
    const [removedPaths, setRemovedPaths] = useState([]);

    const [data, setData_] = useState({
        title_id:       project?.title_id || '',
        title_en:       project?.title_en || '',
        description_id: project?.description_id || '',
        description_en: project?.description_en || '',
        tech_stack:     project ? (Array.isArray(project.tech_stack) ? project.tech_stack.join(', ') : '') : '',
        github_url:     project?.github_url || '',
        demo_url:       project?.demo_url || '',
        is_published:   project?.is_published ?? true,
        order:          project?.order || 0,
    });
    const setData = (key, value) => setData_(prev => ({ ...prev, [key]: value }));

    const handleFiles = (e) => {
        const files = Array.from(e.target.files);
        if (!files.length) return;
        const newPreviews = files.map(f => ({ src: URL.createObjectURL(f), path: null, isExisting: false, file: f }));
        setPreviews(prev => [...prev, ...newPreviews]);
        setNewFiles(prev => [...prev, ...files]);
        if (fileRef.current) fileRef.current.value = '';
    };

    const removePreview = (index) => {
        const item = previews[index];
        if (item.isExisting) {
            setRemovedPaths(prev => [...prev, item.path]);
        } else {
            setNewFiles(prev => prev.filter((_, i) => {
                // find which newFile index corresponds to this preview
                const newPreviewIndex = previews.filter((p, pi) => pi < index && !p.isExisting).length;
                return i !== newPreviewIndex;
            }));
        }
        setPreviews(prev => prev.filter((_, i) => i !== index));
    };

    const submit = (e) => {
        e.preventDefault();
        setProcessing(true);
        setFormErrors({});
        setSuccessMsg(null);

        const fd = new FormData();
        Object.entries(data).forEach(([k, v]) => {
            if (typeof v === 'boolean') fd.append(k, v ? '1' : '0');
            else if (v !== null && v !== undefined) fd.append(k, v);
        });
        newFiles.forEach(f => fd.append('images[]', f));
        removedPaths.forEach(p => fd.append('remove_images[]', p));

        if (isEditing) fd.append('_method', 'PUT');

        router.post(
            isEditing ? `/admin/projects/${project.id}` : '/admin/projects',
            fd,
            {
                onSuccess: () => {
                    setSuccessMsg('Project saved successfully!');
                    setNewFiles([]);
                    setRemovedPaths([]);
                    setTimeout(() => setSuccessMsg(null), 4000);
                },
                onError: (errs) => setFormErrors(errs),
                onFinish: () => setProcessing(false),
            }
        );
    };

    return (
        <AdminLayout title={isEditing ? 'Edit Project' : 'Add Project'}>
            <div className="max-w-2xl">
                <Link href="/admin/projects" className="btn-ghost text-sm mb-6 inline-flex">
                    <ArrowLeft size={16}/> Back to Projects
                </Link>

                <form onSubmit={submit} className="space-y-6">
                    {/* Success alert */}
                    {successMsg && (
                        <div className="flex items-center gap-3 px-4 py-3 rounded-xl bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-400 text-sm animate-fade-up">
                            <CheckCircle size={18} className="shrink-0"/>
                            {successMsg}
                        </div>
                    )}
                    {/* Validation error summary */}
                    {Object.keys(formErrors).length > 0 && (
                        <div className="px-4 py-3 rounded-xl bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-400 text-sm space-y-1">
                            <p className="font-semibold">Please fix the following errors:</p>
                            {Object.values(formErrors).map((msg, i) => (
                                <p key={i} className="text-xs">• {msg}</p>
                            ))}
                        </div>
                    )}
                    {/* Project Info */}
                    <div className="card p-6 space-y-4">
                        <h3 className="font-semibold text-slate-800 dark:text-white">Project Info</h3>
                        <div className="grid sm:grid-cols-2 gap-4">
                            <div>
                                <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Title (English) *</label>
                                <input className="input" value={data.title_en} onChange={e => setData('title_en', e.target.value)} placeholder="e.g. Document Digitization"/>
                                {formErrors.title_en && <p className="text-red-500 text-xs mt-1">{formErrors.title_en}</p>}
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Title (Indonesian) *</label>
                                <input className="input" value={data.title_id} onChange={e => setData('title_id', e.target.value)} placeholder="e.g. Digitalisasi Dokumen"/>
                                {formErrors.title_id && <p className="text-red-500 text-xs mt-1">{formErrors.title_id}</p>}
                            </div>
                        </div>
                        <div>
                            <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Description (English) *</label>
                            <textarea rows={4} className="input resize-none" value={data.description_en}
                                onChange={e => setData('description_en', e.target.value)} placeholder="Describe the project in English..."/>
                            {formErrors.description_en && <p className="text-red-500 text-xs mt-1">{formErrors.description_en}</p>}
                        </div>
                        <div>
                            <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Description (Indonesian) *</label>
                            <textarea rows={4} className="input resize-none" value={data.description_id}
                                onChange={e => setData('description_id', e.target.value)} placeholder="Deskripsikan proyek dalam Bahasa Indonesia..."/>
                            {formErrors.description_id && <p className="text-red-500 text-xs mt-1">{formErrors.description_id}</p>}
                        </div>
                        <div>
                            <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Tech Stack (comma separated)</label>
                            <input className="input" value={data.tech_stack}
                                onChange={e => setData('tech_stack', e.target.value)}
                                placeholder="Laravel, React, Docker, MySQL"/>
                        </div>
                    </div>

                    {/* Multiple Image Upload */}
                    <div className="card p-6 space-y-4">
                        <div>
                            <h3 className="font-semibold text-slate-800 dark:text-white flex items-center gap-2">
                                <ImageIcon size={16}/> Project Images
                                <span className="text-xs font-normal text-slate-400">(optional, max 10)</span>
                            </h3>
                            <p className="text-xs text-slate-400 mt-0.5">
                                First image = card thumbnail. All images shown in detail modal as gallery.
                            </p>
                        </div>

                        {/* Preview grid */}
                        {previews.length > 0 && (
                            <div className="grid grid-cols-3 gap-3">
                                {previews.map((item, i) => (
                                    <div key={i} className="relative aspect-video rounded-xl overflow-hidden border border-slate-200 dark:border-slate-700 group">
                                        <img src={item.src} alt={`Image ${i + 1}`} className="w-full h-full object-cover"/>
                                        {/* First image badge */}
                                        {i === 0 && (
                                            <span className="absolute top-1 left-1 text-xs bg-primary-600 text-white px-1.5 py-0.5 rounded font-medium">
                                                Cover
                                            </span>
                                        )}
                                        <button type="button" onClick={() => removePreview(i)}
                                            className="absolute top-1 right-1 w-6 h-6 rounded-full bg-red-500 text-white flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity shadow">
                                            <X size={12}/>
                                        </button>
                                    </div>
                                ))}
                                {/* Add more button */}
                                {previews.length < 10 && (
                                    <button type="button" onClick={() => fileRef.current?.click()}
                                        className="aspect-video rounded-xl border-2 border-dashed border-slate-200 dark:border-slate-700 flex flex-col items-center justify-center gap-1 text-slate-400 hover:border-primary-400 hover:text-primary-500 transition-colors">
                                        <Upload size={18}/>
                                        <span className="text-xs">Add more</span>
                                    </button>
                                )}
                            </div>
                        )}

                        {/* Empty state upload zone */}
                        {previews.length === 0 && (
                            <button type="button" onClick={() => fileRef.current?.click()}
                                className="w-full h-36 border-2 border-dashed border-slate-200 dark:border-slate-700 rounded-xl flex flex-col items-center justify-center gap-2 text-slate-400 hover:border-primary-400 hover:text-primary-500 transition-colors">
                                <Upload size={24}/>
                                <span className="text-sm">Click to upload images</span>
                                <span className="text-xs">PNG, JPG, WEBP — up to 10 images, 2MB each</span>
                            </button>
                        )}

                        <input ref={fileRef} type="file" accept="image/*" multiple className="hidden" onChange={handleFiles}/>

                        {processing && (
                            <div className="w-full h-1.5 bg-slate-100 dark:bg-slate-700 rounded-full overflow-hidden">
                                <div className="h-full bg-primary-500 rounded-full animate-pulse"/>
                            </div>
                        )}
                        {formErrors.images && <p className="text-red-500 text-xs">{formErrors.images}</p>}
                    </div>

                    {/* Links */}
                    <div className="card p-6 space-y-4">
                        <div>
                            <h3 className="font-semibold text-slate-800 dark:text-white">Links</h3>
                            <p className="text-xs text-slate-400 mt-0.5">Optional — shown in the project detail modal.</p>
                        </div>
                        <div className="grid sm:grid-cols-2 gap-4">
                            <div>
                                <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5 flex items-center gap-1.5">
                                    <LinkIcon size={13}/> GitHub URL
                                </label>
                                <input type="url" className="input" value={data.github_url}
                                    onChange={e => setData('github_url', e.target.value)} placeholder="https://github.com/..."/>
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5 flex items-center gap-1.5">
                                    <ExternalLink size={13}/> Demo / Live URL
                                </label>
                                <input type="url" className="input" value={data.demo_url}
                                    onChange={e => setData('demo_url', e.target.value)} placeholder="https://..."/>
                            </div>
                        </div>
                    </div>

                    {/* Publish */}
                    <div className="card p-4 flex items-center gap-3">
                        <input type="checkbox" id="is_published" checked={data.is_published}
                            onChange={e => setData('is_published', e.target.checked)}
                            className="w-4 h-4 accent-primary-600 rounded"/>
                        <label htmlFor="is_published" className="text-sm font-medium text-slate-700 dark:text-slate-300">
                            Published (visible on portfolio)
                        </label>
                    </div>

                    <button type="submit" disabled={processing} className="btn-primary w-full justify-center">
                        <Save size={16}/> {isEditing ? 'Save Changes' : 'Create Project'}
                    </button>
                </form>
            </div>
        </AdminLayout>
    );
}
